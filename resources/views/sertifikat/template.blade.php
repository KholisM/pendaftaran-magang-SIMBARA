```blade
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

@page {
    size: A4 landscape;
    margin: 10px;
}

body{
    margin:0;
    padding:0;
    font-family: DejaVu Sans, sans-serif;
    color:#1f2937;
}

.certificate{
    position:relative;
    width:100%;
    height:100%;
    border:10px solid #0F4C81;
    padding:10px;
    box-sizing:border-box;
}

.inner{
    position:relative;
    border:4px solid #F7941D;
    min-height:500px;
    padding:35px;
}

.top-bar{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:12px;
    background:#0F4C81;
}

.bottom-bar{
    position:absolute;
    bottom:0;
    left:0;
    width:100%;
    height:12px;
    background:#F7941D;
}

.corner-top{
    position:absolute;
    top:0;
    right:0;
    width:120px;
    height:120px;
    background:#F7941D;
    opacity:.15;
}

.corner-bottom{
    position:absolute;
    bottom:0;
    left:0;
    width:120px;
    height:120px;
    background:#0F4C81;
    opacity:.15;
}

.watermark{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    width:350px;
    opacity:0.05;
}

.logo{
    width:90px;
}

.header{
    text-align:center;
}

.instansi{
    font-size:28px;
    font-weight:bold;
    color:#0F4C81;
}

.kota{
    font-size:18px;
    color:#666;
}

.title{
    margin-top:20px;
    text-align:center;
    font-size:42px;
    font-weight:bold;
    letter-spacing:5px;
    color:#0F4C81;
}

.subtitle{
    text-align:center;
    color:#777;
    margin-bottom:25px;
}

.text{
    text-align:center;
    font-size:18px;
    margin-top:15px;
}

.nama{
    text-align:center;
    font-size:40px;
    font-weight:bold;
    color:#F7941D;
    margin:20px 0 10px;
    text-transform:uppercase;
}

.line{
    width:500px;
    height:3px;
    background:#F7941D;
    margin:auto;
}

.kampus{
    text-align:center;
    font-size:18px;
    margin-top:15px;
    color:#374151;
}

.paragraf{
    text-align:center;
    margin-top:25px;
    line-height:1.8;
    font-size:17px;
}

.predikat{
    display:inline-block;
    margin-top:15px;
    padding:8px 25px;
    border:2px solid #0F4C81;
    color:#0F4C81;
    font-weight:bold;
    border-radius:30px;
}

.signature{
    margin-top:40px;
    width:260px;
    float:right;
    text-align:center;
}

.signature-name{
    margin-top:70px;
    font-weight:bold;
    text-decoration:underline;
}

.clear{
    clear:both;
}

</style>

</head>
<body>

<div class="certificate">

    <div class="top-bar"></div>
    <div class="bottom-bar"></div>

    <div class="inner">

        <div class="corner-top"></div>
        <div class="corner-bottom"></div>

        <img src="{{ public_path('assets/img/capil.png') }}"
             class="watermark">

        <table width="100%">
            <tr>

                <td width="15%" align="center">
                    <img src="{{ public_path('assets/img/capil.png') }}"
                         class="logo">
                </td>

                <td width="70%" align="center">

                    <div class="instansi">
                        DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL
                    </div>

                    <div class="kota">
                        KOTA BOGOR
                    </div>

                </td>

                <td width="15%" align="center">
                    <img src="{{ public_path('assets/img/capil.png') }}"
                         class="logo">
                </td>

            </tr>
        </table>

        <div class="title">
            SERTIFIKAT MAGANG
        </div>

        <div class="subtitle">
            Nomor :
            {{ date('Y') }}/MAGANG/{{ str_pad($lamaran->id,4,'0',STR_PAD_LEFT) }}
        </div>

        <div class="text">
            DIBERIKAN KEPADA
        </div>

        <div class="nama">
            {{ strtoupper($biodata->nama_lengkap ?? $lamaran->nama) }}
        </div>

        <div class="line"></div>

        <div class="kampus">
            {{ $biodata->jurusan ?? $lamaran->jurusan }}
            <br>
            {{ $biodata->asal_sekolah ?? $lamaran->asal_sekolah }}
        </div>

        <div class="paragraf">

            Sebagai bentuk penghargaan atas dedikasi,
            komitmen, dan kontribusi yang telah diberikan
            selama mengikuti Program Magang pada

            <strong>
                Dinas Kependudukan dan Pencatatan Sipil Kota Bogor
            </strong>

            <br><br>

            Periode Magang

            <strong>
                {{ \Carbon\Carbon::parse($lamaran->tanggal_mulai)->translatedFormat('d F Y') }}
            </strong>

            s/d

            <strong>
                {{ \Carbon\Carbon::parse($lamaran->tanggal_selesai)->translatedFormat('d F Y') }}
            </strong>

            <br><br>

            <span class="predikat">
                PREDIKAT : SANGAT BAIK
            </span>

        </div>

        <div class="signature">

            Bogor,
            {{ now()->translatedFormat('d F Y') }}

            <br><br>

            Kepala Dinas Kependudukan
            <br>
            dan Pencatatan Sipil

            <div class="signature-name">
                _______________________
            </div>

            NIP. ___________________

        </div>

        <div class="clear"></div>

    </div>

</div>

</body>
</html>
```
