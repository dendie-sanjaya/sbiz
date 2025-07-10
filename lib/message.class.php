<?php
class message {
	public static function getMsg($id) {
		switch($id) {
			case 'addSuccess':
				return 'Data telah berhasil disimpan';
				break;
			case 'editSuccess':
				return 'Data telah berhasil dikoreksi';
				break;
			case 'deleteSuccess':
				return 'Data telah berhasil dihapus';
				break;
			case 'emptySuccess':
				return 'Data tidak di temukan atau tidak ada data';
				break;
			case 'addFailed':
				return 'Data gagal disimpan, silakan ulangi menyimpan data';
				break;
			case 'ambilSuccess':
				return 'Data telah berhasil diambil dari pool';
				break;
			case 'kirimSuccess':
				return 'Data telah berhasil dikirim ke pool';
				break;
			case 'restoreSuccess':
				return 'Data telah berhasil di pulihkan';
				break;
			case 'insertSuccess':
				return 'Data telah berhasil ditambahkan';
				break;
			case 'smsKirimSuccess':
				return 'SMS berhasil dikirim';
				break;
			case 'smsKirimFailed':
				return 'SMS gagal dikirim';
				break;
			case 'deleteFailed':
				return 'Data gagal dihapus';
				break;
			case 'editFailed':
				return 'Data gagal dikoreksi';
				break;
			case 'loginFailed':
				return 'Login tidak berhasil, silakan coba lagi';
				break;
			case 'passwordFailed':
				return 'Password sekarang tidak sesuai, silakan coba lagi';
				break;
			case 'passwordNewFailed':
				return 'Password Baru dan Konfirmasi Password Baru tidak sesuai, silakan coba lagi';
				break;
			case 'passwordNewSuccess':
				return 'Password telah berhasil diubah';
				break;			
			case 'filterData':
				return 'Silakan melakukan filter data terlebih dahulu';
				break;			
			case 'resetSuccess':
				return 'Data berhasil dikosongkan/reset';
				break;			
			case 'enableSuccess':
				return 'Data berhasil diaktifkan';
				break;			
			case 'enableFailed':
				return 'Data gagal diaktifkan';
				break;			
			case 'disableSuccess':
				return 'Data berhasil di non-aktifkan';
				break;			
			case 'disableFailed':
				return 'Data gagal di non-diaktifkan';
				break;		
			case 'detailSuccess':
				return 'Data berhasil di tampilkan';
				break;				
			case 'detailFailed':
				return 'Data gagal di tampilkan';
				break;
			case 'isExistSuccess':
				return 'Data sudah ada';
				break;				
			case 'notExistSuccess':
				return 'Data belum ada';
				break;								
			case 'backupSuccess':
				return 'Proses backup data berhasil';
				break;								
			case 'backupFailed':
				return 'Proses backup data gagal';
				break;								
			case 'restoreSuccess':
				return 'Proses restore data berhasil';
				break;								
			case 'restoreFailed':
				return 'Proses restore data gagal';
				break;								
			case 'resortingSuccess':
				return 'Proses pengurutan berhasil';
				break;								
			case 'resortingFailed':
				return 'Proses pengurutan gagal';
				break;								
			case 'publishedSuccess':
				return 'Data berhasil di publis';
				break;			
			case 'publishedFailed':
				return 'Data gagal di publis';
				break;			
			case 'unPublishedSuccess':
				return 'Data berhasil di tidak di publis';
				break;			
			case 'unPublishedFailed':
				return 'Data gagal di tidak di publis';
				break;		
			case 'soalEmptySuccess':
				return 'Data soal tidak ditemukan atau belum disetting';
				break;			
			case 'archiveSuccess':
				return 'Data berhasil di arsipkan';
				break;			
			case 'searchSuccess':
				return 'Silakan lakukan pencarian barang terlebih dahulu';
				break;		
			case 'dataEmptyFailed':
				return 'Tidak ada data yang dipilih';
				break;	
			case 'postingSuccess':
				return 'Data berhasil di posting';
				break;				
			default:

			return false;
		}      
	}
}
?>
