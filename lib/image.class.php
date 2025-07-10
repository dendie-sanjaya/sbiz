<?php
/*******************************************************************************                                                      
* Lib:  Image-D                                                                *
* Version:  1                                                                  *
* Tanggal:  12-01-2007                                                         *
* Pembuat:  Dendie                                                             *
* License:  Freeware                                                           *
*																			   *
* This class for manipulation image	                               			   *
*																			   *
* You can  use, modification and distribution 								   *	                                                                  
*******************************************************************************/

class image
{	
	//Private atribut
	private $error=null;         //Untuk pesan menyimpan error
	private $TipeUkuran;         //Untuk menyimpan tipe ukuran
	private $FileSumber;         //Untuk menyimpan file sumber 
	private $PersenUkuran; 		 //Untuk menyimpan persen ukuran
	private $LebarUkuran;		 //Untuk menyimpan lebar ukuran
	private $TinggiUkuran;		 //Untuk menyimpan tinggi ukuran
	private $FolderSimpan;		 //Untuk menyimpan folder menyimpan
	private $NamaFile;			 //Untuk menyimpan nama file baru
    private $SpamLebarImage;	 //Untuk menyimpan lebar image antispam
	private $SpamTinggiImage;	 //Untuk menyimpan tinggi image antispam
	private $SpamWarnaLatar;	 //Untuk menyimpan warna latar image antispam
	private $SpamWarnaStr;		 //Untuk menyimpan warna string antispam
	private $SpamStrKata;		 //Untuk menyimpan kata antispam
	private $SpamStrPjn;		 //Untuk menyimpan panjang string anti spam
	private $SpamTipe;			 //Untuk menyimpan tipe spam	
	private $SpamlatarImage;     //Untuk menyimpan latar image antispam
	private $SpamTipeImage;      //Untuk menyimpan tipe latar image antispam
	
	function InfoImage($FileImage)
	{
	    //Memeriksa file
		if(!file_exists($FileImage))
		{
		   $this->error= $this->error."Error [Image::InfoImage] : File gambar tidak ditemukan\n";
		   return false;
		}   
		//Mengambil informasi image
		$TempInfoImage=getimagesize($FileImage);
		$lebar=$TempInfoImage[0];
		$tinggi=$TempInfoImage[1];
		$mime=$TempInfoImage['mime'];
		$bit=$TempInfoImage['bits'];
		$chanel=$TempInfoImage['channels'];
		$ukuran=filesize($FileImage);
		//Mengambil nama file
		$HitGaring1=substr_count($FileImage,'/');
		$HitGaring2=substr_count($FileImage,'\\');
		if($HitGaring1 > 0)
		{
		   $NamaArray=explode('/',$FileImage);
		   $TempNama=$NamaArray[count($NamaArray)-1]; 
		}   
 		if($HitGaring2 > 0)
		{
		   $NamaArray=explode('\\',$FileImage);
		   $TempNama=$NamaArray[count($NamaArray)-1]; 
		}
		if(($HitGaring1 == 0) && ($HitGaring2 == 0))
		   $TempNama=$FileImage; 
		//Pemberian satuan byte   
		switch ($ukuran)
		{
			case $ukuran<1000:
				$ukuran='1 KB';
				break;
			case ($ukuran>=1000)&&($ukuran<1000000):
				$ukuran=number_format($ukuran/1000,0);
				$ukuran=$ukuran.' KB';
				break;
			case ($ukuran>=1000000)&&($ukuran<1000000000):
				$ukuran=number_format($ukuran/1000000,1,',','');
				$ukuran=$ukuran.' MB';
				break;
			default:
				$ukuran=number_format($ukuran/1000000000,2,',','');
				$ukuran=$ukuran.' GB';
				break;
		}
		return array('nama'=>$TempNama,'lebar'=>$lebar,'tinggi'=>$tinggi,'mime'=>$mime,'ukuran'=>$ukuran,'bit'=>$bit,'chanel'=>$chanel);
	}
	
	private function UkuranImage()
	{
	   //Memeriksa folder
		if(!is_dir($this->FolderSimpan))
		{
		   $this->error= $this->error."Error [Image::UkuranImagePersen/resizeImagePixel] : Folder untuk menyimpan tidak ada\n";
		   return false;
		}   
	   //Mengambil ukuran gambar 
	   $ukuran=$this->InfoImage($this->FileSumber);
	   //Memeriksa return objek ukuran
	   if($ukuran != false)
	   {
		   //Mengambil nama file
		   if($this->NamaFile==false)
		   { 
		   	  $NamaFileArray=explode('.',$ukuran['nama']);
			  $JmlArray=count($NamaFileArray)-1;
			  for($i=0;$i<$JmlArray;$i++)
			  { 			
			     $this->NamaFile.=$NamaFileArray[$i];
				 if($i<($JmlArray-1))
				     $this->NamaFile.= '.';
			  }
		   }		   
		   //Mengambil ukuran image original
		   $ULebarOrg=$ukuran['lebar'];
		   $UTinggiOrg=$ukuran['tinggi'];
		   //Menghitung perubahan ukuran gambar
		   if($this->TipeUkuran=='persen')
		   {
			   $ULebarBaru=$ukuran['lebar'] * $this->PersenUkuran;
			   $UTinggiBaru=$ukuran['tinggi'] * $this->PersenUkuran;
		   }
		   if($this->TipeUkuran=='pixel')
		   {
			   $ULebarBaru=$this->LebarUkuran;
			   $UTinggiBaru=$this->TinggiUkuran;
		   }
		   //Mengambil tipe image
		   $TipeImage=$ukuran['mime'];
		   //Membuat image temporari
		   $TempImage=imagecreatetruecolor($ULebarBaru,$UTinggiBaru);
		   //Memeriksa tipe image 
		   switch(trim($TipeImage))
		   {
			  case 'image/png':  
				 //Untuk menangani background transparan
				 $background = imagecolorallocate($TempImage, 0, 0, 0);
				 imagecolortransparent($TempImage, $background);
				 imagealphablending($TempImage, false);
				 imagesavealpha($TempImage, true);
				 //Bikin flie berdasarkan tipe file
				 $TempFileSumber = imagecreatefrompng($this->FileSumber);
				 break;
			  case 'image/gif':  
				 //Untuk menangani background transparan
				 $background = imagecolorallocate($TempImage, 0, 0, 0);
				 imagecolortransparent($TempImage, $background);
				 imagealphablending($TempImage, true);
				 imagesavealpha($TempImage, true);
				 //Bikin flie berdasarkan tipe file
				 $TempFileSumber = imagecreatefromgif($this->FileSumber);
				 break;
			  case 'image/jpeg':
				 $TempFileSumber = imagecreatefromjpeg($this->FileSumber);
				 break;
			  default:
			     $this->error= $this->error."Error [Image::UkuranImagePersen/resizeImagePixel] : Tipe image image tidak dikenali\n";
				 return false; 	 
		   }
		   //Merubah ukuran image
		   imagecopyresized($TempImage,$TempFileSumber,0,0,0,0,$ULebarBaru,$UTinggiBaru,$ULebarOrg,$UTinggiOrg);
		   //Membuat tipe image
		   switch(trim($TipeImage))
		   {
			  case 'image/png':  
				 imagepng($TempImage,$this->FolderSimpan.$this->NamaFile.'.png');
				 break;
			  case 'image/gif':  
				 imagegif($TempImage,$this->FolderSimpan.$this->NamaFile.'.gif');
				 break;
			  case 'image/jpeg':  
				 imagejpeg($TempImage,$this->FolderSimpan.$this->NamaFile.'.jpg');
				 break;
		   }
		   //Menghapus temp image
		   imagedestroy($TempImage);
		   imagedestroy($TempFileSumber);
		   return true;
	   }
	   return false;
	}
	
	function UkuranImagePersen($FileSumber,$PersenUkuran=1,$FolderSimpan='./',$NamaFile=false)
	{
	   //Memberikan nilai ke atribut
	   $this->TipeUkuran='persen';
	   $this->FileSumber=$FileSumber;
	   $this->PersenUkuran=$PersenUkuran;
	   $this->FolderSimpan=$FolderSimpan;
	   $this->NamaFile=$NamaFile;
	   //Memanggil fungsi rubah ukuran
	   return $this->UkuranImage();
	}
	
	function resizeImagePixel($FileSumber,$LebarUkuran,$TinggiUkuran,$FolderSimpan='./',$NamaFile=false)
	{
	   //Memberikan nilai ke atribut
	   $this->TipeUkuran='pixel';
	   $this->FileSumber=$FileSumber;
	   $this->LebarUkuran=$LebarUkuran;
	   $this->TinggiUkuran=$TinggiUkuran;
	   $this->FolderSimpan=$FolderSimpan;
	   $this->NamaFile=$NamaFile;
	   //Memanggil fungsi rubah ukuran
	   return $this->UkuranImage();
	}

	private function AntiSpam()
	{
	   //Inisialiasai ukuran font
	   $UkuranFont=5;
	   //Memeriksa status kalimat
	   if($this->SpamStrKata==false)
	   {
		  $DaftarAcakKalimat='ABCDEFGHIJKLMNOPQRSTUPWQYZabcdefghijklmnopqrstupweyz0123456789';
		  //Random karakter
		  $KataImage=substr(str_shuffle($DaftarAcakKalimat),0,$this->SpamStrPjn); 
		}
		else
		{
		   $this->SpamStrPjn=strlen($this->SpamStrKata);
		   $KataImage=$this->SpamStrKata;
		}
		//Memeriksa tipe anti spam
  		if($this->SpamTipe==0)
		{
			   //Memeriksa ukuran image
			   if($this->SpamLebarImage < 1 )
			   {
				 $this->error= $this->error."Error [Image::AntiSpam1] : Lebar image kurang dari 1 pixel\n";
				 return false;
			   }
			   if($this->SpamTinggiImage < 1 )
			   {
				 $this->error= $this->error."Error [Image::AntiSpam1] : Tinggi image kurang dari 1 pixel\n";
				 return false;
			   }
			   //Membuat image
			   $TempImage=imagecreatetruecolor($this->SpamLebarImage,$this->SpamTinggiImage);
			   //Memberikan warna latar
			   if(!is_array($this->SpamWarnaLatar))
			   {
				 $this->error= $this->error."Error [Image::AntiSpam1] : Tipe data warna latar bukan array\n";
				 return false;
			   }
			   $WarnaLatar=imagecolorallocate($TempImage,$this->SpamWarnaLatar[0],$this->SpamWarnaLatar[1],$this->SpamWarnaLatar[2]);
			   //Memberikan warna string
			   if(!is_array($this->SpamWarnaLatar))
			   {
				 $this->error= $this->error."Error [Image::AntiSpam1] : Tipe data warna latar bukan array\n";
				 return false;
			   }
			   imagefill($TempImage,$this->SpamLebarImage-1,$this->SpamTinggiImage-1,$WarnaLatar);
			   //Memberikan warna kata
	    }
  		if($this->SpamTipe==1)
		{
		   //Memeriksa tipe image 
		   switch(trim($this->SpamTipeImage))
		   {
			  case 'image/png':  
				 $TempImage = imagecreatefrompng($this->SpamlatarImage);
				 break;
			  case 'image/gif':  
				 $TempImage = imagecreatefromgif($this->SpamlatarImage);
				 break;
			  case 'image/jpeg':
				 $TempImage = imagecreatefromjpeg($this->SpamlatarImage);
				 break;
			  default:
			     $this->error= $this->error."Error [Image::AntiSpam2] : Tipe image image tidak dikenali\n";
				 return false; 	 
		   }
		}
		$WarnaStr=imagecolorallocate($TempImage,$this->SpamWarnaStr[0],$this->SpamWarnaStr[1],$this->SpamWarnaStr[2]); 
		//Menuliskan kalimat ke image
		$SumbuX=($this->SpamLebarImage-(imagefontwidth($UkuranFont)*$this->SpamStrPjn))/2; 
		$SumbuY=(imagesy($TempImage)-imagefontheight($UkuranFont))/2;
		imagestring($TempImage,$UkuranFont,$SumbuX,$SumbuY,$KataImage,$WarnaStr);
		$this->SpamDisplayImage=$TempImage;
	    //Info untuk selalu di update
		header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		//Menghilangkan cache HTTP/1.1
		header('Cache-Control: no-store, no-cache, must-revalidate');
	    header('Cache-Control: post-check=0, pre-check=0,', false);
		//Menghilangkan cache HTTP/1.0
		header('Pragma: no-cache');
	    //Membuat image
	    header('Content-type: image/jpeg');
	    imagejpeg($this->SpamDisplayImage);
	    //Bebaskan memori
	    imagedestroy($this->SpamDisplayImage);
	    //Mengembalikan hasil kata yang diacak
		return $KataImage;
	}

	function AntiSpam1($StrKata=false,$WarnaLatar=false,$WarnaStr=false,$LebarImage=false,$TinggiImage=false,$StrPjn=5)
	{
	    //Memberikan nilai ke attribut
		if($WarnaLatar == false)
		   $WarnaLatar=array(255,255,0);
		if($WarnaStr == false)
		   $WarnaStr=array(0,0,0);
		if($LebarImage == false)
		   $LebarImage=75;
		if($TinggiImage == false)
		   $TinggiImage=35;
	    $this->SpamTipe=0;
		$this->SpamLebarImage=$LebarImage;
		$this->SpamTinggiImage=$TinggiImage;
		$this->SpamWarnaLatar=$WarnaLatar;
		$this->SpamWarnaStr=$WarnaStr;
		$this->SpamStrKata=$StrKata;
		$this->SpamStrPjn=$StrPjn;
		//Memanggil fungsi anti spam
		return $this->AntiSpam();
	}
	
	function AntiSpam2($LatarImage,$StrKata=false,$WarnaStr=false,$StrPjn=5)
	{
	    //Memberikan nilai ke attribut
		$InfoImage=$this->InfoImage($LatarImage);
		if(!$InfoImage)
		{
		   $this->error="Error [Image::AntiSpam2] : Image tidak ditemukan";
		   return false;
		} 
		else
		{
			if($WarnaStr == false)
			   $WarnaStr=array(0,0,0);
			$this->SpamTipe=1;
			$this->SpamLebarImage=$InfoImage['lebar'];
			$this->SpamTinggiImage=$InfoImage['tinggi'];
			$this->SpamTipeImage=$InfoImage['mime'];
			$this->SpamlatarImage=$LatarImage;
			$this->SpamStrKata=$StrKata;
			$this->SpamWarnaStr=$WarnaStr;
			$this->SpamStrPjn=$StrPjn;
			//Memanggil fungsi anti spam
			return $this->AntiSpam();
		}  
	}
	
	function ErrorMsg()
	{
	   //Untuk menampilkan error
	   echo $this->error;
	}	
}
?>
