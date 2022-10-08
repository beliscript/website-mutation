<?php 
if(!function_exists('format_indo')){
    function format_indo($date){
        date_default_timezone_set('Asia/Jakarta');
        $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
        
        // memisahkan format tahun menggunakan substring
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl   = substr($date, 8, 2);
        $waktu = substr($date, 11, 5);
        $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun . " " . $waktu;
        return($result);
    }
}