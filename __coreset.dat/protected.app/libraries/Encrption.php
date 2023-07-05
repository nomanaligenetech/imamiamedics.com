<?php

/*****************usage example******************** 
$clsen=new Encrption();
echo $clsen->Encrypt("Hasan Agha");
echo $clsen->Decrypt($clsen->Encrypt("Hasan Agha"));
//*************************************************/
class Encrption
	{
		/*function Encrypt($string)
			{
				for($a=0;$a<strlen($string);$a++)
					{ 
						$enstr.= chr(ord(substr($string,$a,1))-115);
					}
					return base64_encode($enstr);
			}
		function Decrypt($string)
			{
				$string=base64_decode($string);
				for($a=0;$a<strlen($string);$a++)
					{
						$enstr.= chr(ord(substr($string,$a,1))+115);
					}
				return $enstr;
			}*/
		function Encrypt($string)
			{$enstr="";
				for($a=0;$a<strlen($string);$a++)
					{ 
						$no=rand(0,255);
						$enstr.= chr(ord(substr($string,$a,1))-$no);
						$enstr.=chr($no);
					}
					return base64_encode($enstr);
			}
		function Decrypt($string)
			{$enstr="";	
				$string=base64_decode($string);
				for($a=0;$a<strlen($string);$a+=2)
					{ 
						$no=ord($string[$a+1]);
						$enstr.= chr(ord(substr($string,$a,1))+$no);
					}
					return $enstr;
			}
			
	}
?>