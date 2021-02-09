# Self-elevate the script if required
if (-Not ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole] 'Administrator')) {
    if ([int](Get-CimInstance -Class Win32_OperatingSystem | Select-Object -ExpandProperty BuildNumber) -ge 6000) {
     $CommandLine = "-File `"" + $MyInvocation.MyCommand.Path + "`" " + $MyInvocation.UnboundArguments
     Start-Process -FilePath PowerShell.exe -Verb Runas -ArgumentList $CommandLine
     Exit
    }
   }
function random_mac {   
    $mac = "02"
    while ($mac.length -lt 12) 
	{ 
		$mac += "{0:X}" -f $(get-random -min 0 -max 16) 
	} 
		
    $Delimiter = "-"
		for ($i = 0 ; $i -le 10 ; $i += 2) 
		{ $newmac += $mac.substring($i,2) + $Delimiter }
		$setmac = $newmac.substring(0,$($newmac.length - $Delimiter.length)) 
 $setmac
}


function disconnect-wifi { 
    $CurrentSSID = (netsh wlan show interface | Select-String 'Profile' | Foreach-Object {$_.ToString()})
    $CurrentSSID = $CurrentSSID.trim("Connection mode        : Profile     Profile                : ")
    Write-Host "Current WLAN SSID: $CurrentSSID"  -ForegroundColor Yellow

    $WIFI = Get-WmiObject -Class Win32_NetworkAdapterConfiguration | Where-Object { $_.IpEnabled -eq $true -and $_.DhcpEnabled -eq $true}
    Write-Host "Releasing IP addresses:" ($WIFI.IPAddress | Select-Object -first 1)  -ForegroundColor Yellow 
    $WIFI.ReleaseDHCPLease() | out-Null 

    # Make sure the release has happened, else give it 2 sec extra. 
    $WIFI = Get-WmiObject -Class Win32_NetworkAdapterConfiguration | Where-Object { $_.IpEnabled -eq $true -and $_.DhcpEnabled -eq $true} 
    if ($Null -ne $WIFI.DefaultIPGateway) { 
    Write-Output "Release of IP Address had not completed, waiting 1 Seconds" 
    Start-Sleep -Seconds 2
    }

    Write-Host "Disconnecting from WiFi" -ForegroundColor Yellow 
    & netsh wlan disconnect | Out-Null
} 


function new-wifimac ($wifiadapter, $ssid, $newmac){ 

#    Write-Output "Wifi AdapterName: $wifiadapter" 
#    Write-Output "SSID: $ssid" 
#    Write-Output "New MAC Address to set: $newmac" 

    $oldmac = (Get-NetAdapter -Name $wifiadapter).MACAddress 
    Write-Output "OLD MAC Address: $oldmac" 

    if ($oldmac -like $newmac) {
        Write-Host "Old MAC and New MAC are identical, generating a new MAC Address" -ForegroundColor Red
        $newmac = random_mac
        Write-Output "New MAC Address to set: $newmac" 
        }

    Set-NetAdapter -Name $wifiadapter -MacAddress $newmac -Confirm:$false 
    Get-NetAdapter -Name $wifiadapter | Disable-NetAdapter -Confirm:$false -Verb runAs
    Get-NetAdapter -Name $wifiadapter | Enable-NetAdapter -Confirm:$false -Verb runAs
    $currentmac = (Get-NetAdapter -Name $wifiadapter).MACAddress 
    Write-Output "NEW MAC Address: $currentmac" 

    Write-Host "Connecting to SSID: $ssid" -ForegroundColor Yellow 
    & netsh wlan connect name=$ssid ssid=$ssid

    $NoIP = 0
    Do { 
        $WIFI = Get-WmiObject -Class Win32_NetworkAdapterConfiguration | Where-Object { $_.IpEnabled -eq $true -and $_.DhcpEnabled -eq $true}
        
        if ($null -ne $WIFI.DefaultIPGateway) { 
            $NoIP = 5
        }
        else {
            Start-Sleep -Seconds 2 
            Write-Host "Waiting for IP Address" 
            $NoIP += 1
        }
    } While ($NoIP -lt 5) 
    Write-Host "New IP addresses" ($WIFI.IPAddress | Select-Object -first 1)  -ForegroundColor Yellow 
}


function test-wifi ($probe){ 
    if (Test-NetConnection -ComputerName $probe -CommonTCPPort HTTP -InformationLevel Quiet) { 
        $result = "Working" 
    } 
    else { 
        $result = "NotWorking" 
    }
$result 
}


# Specify $SSID manually 
# $ssid = 'SSID-to-Connect-to' 
# 
# Or use the currently used SSID to reconnect to. 
$ssid = (& netsh wlan show interfaces | Select-String ' SSID ' | Foreach-Object {$_.ToString()}).replace("    SSID                   : ","$null")

# Specify WLAN Adapter Name Manually 
# $wifiadapter = 'RTWlanE'
# 
# Or Try to identify the Wi-Fi Adapter 
$wifiadapter = (Get-NetAdapter | where Status -EQ "Up" | where MediaType -EQ "802.11" |  Where { $_.IpEnabled -eq $true -and $_.DhcpEnabled -eq $true} | select *).MacAddress.replace(":","-").Name
#  where MacAddress -EQ (Get-WmiObject -Class Win32_NetworkAdapterConfiguration |
# Specify a MAC Address manually
# $newmac = "02-F4-D7-B2-FE-D8"
#
# Or generate a new Random MAC Address
$newmac = random_mac

disconnect-wifi
new-wifimac -wifiadapter $wifiadapter -ssid $ssid -newmac $newmac 
test-wifi -probe www.msftncsi.com