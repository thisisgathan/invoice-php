<!DOCTYPE html>
<?php
require 'controller/koneksi.php';
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
  $id = $_GET['id'];
  //query untuk mengambil data invoice dan pelanggan
  $query = "SELECT *, subtotal * (Diskon/100) as Total_Diskon, subtotal * (Pajak/100) as Total_Pajak FROM invoice JOIN pelanggan ON invoice.id_pelanggan = pelanggan.id_pelanggan WHERE invoice.id_invoice = $id";
  $data = mysqli_query($conn, $query);
  $invoice = mysqli_fetch_assoc($data);

  //query untuk mengambil data detail invoice
  $query = "SELECT detail_invoice.*, produk.*, detail_invoice.Harga_Jual - detail_invoice.Harga_Promo AS Total_Diskon
    FROM detail_invoice
    JOIN produk ON detail_invoice.ID_Produk = produk.ID_Produk
    WHERE detail_invoice.id_invoice = $id;
    ";
  $data = mysqli_query($conn, $query);

  function rupiah($number)
  {
    $rupiah = "Rp " . number_format($number, 0, ',', '.');
    return $rupiah;
  }
} else {
  header('Location: 500.html');
}
?>

<html class="no-js" lang="en">

<head>
  <!-- Meta Tags -->
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="author" content="Laralink" />
  <!-- Site Title -->
  <title>Invoice-<?php echo $id;?></title>
  <link rel="stylesheet" href="css/print.css" />
</head>

<body>
  <div class="tm_container">
    <div class="tm_invoice_wrap">
      <div class="tm_invoice tm_style1 tm_type2" id="tm_download_section">
        <div class="tm_bars">
          <span class="tm_accent_bg"></span>
          <span class="tm_accent_bg"></span>
          <span class="tm_accent_bg"></span>
        </div>
        <div class="tm_bars tm_type1">
          <span class="tm_accent_bg"></span>
          <span class="tm_accent_bg"></span>
          <span class="tm_accent_bg"></span>
        </div>
        <div class="tm_shape">
          <div class="tm_shape_in tm_accent_bg"></div>
        </div>
        <div class="tm_shape_2 tm_primary_color">
          <div class="tm_shape_2_in tm_accent_color"></div>
        </div>
        <div class="tm_shape_2 tm_type1 tm_primary_color">
          <div class="tm_shape_2_in tm_accent_color"></div>
        </div>
        <!-- <div class="tm_shape_4 tm_primary_bg"></div> -->
        <div class="tm_shape tm_type1">
          <div class="tm_shape_in tm_accent_bg"></div>
        </div>
        <div class="tm_invoice_in">
          <div class="tm_invoice_head tm_align_center tm_mb20">
            <div class="tm_invoice_left">
              <div class="tm_logo">
                <img src="images/logo.png" alt="Logo" />
              </div>
            </div>
            <div class="tm_invoice_right tm_text_right"></div>
          </div>
          <div class="tm_invoice_info tm_mb20">
            <div class="tm_invoice_info_list">
              <p class="tm_invoice_date tm_m0">
                Date: <b class="tm_primary_color">
                  <?php echo $invoice['Tanggal_Invoice']; ?>
                </b><br>
                Jatuh Tempo: <b class="tm_primary_color">
                  <?php echo $invoice['Tanggal_JatuhTempo']; ?>
                </b><br>
                Invoice No: <b class="tm_primary_color">
                  <?php echo $invoice['ID_Invoice']; ?>
                </b>
              </p>
            </div>
          </div>
          <div class="tm_invoice_head tm_mb10">
            <div class="tm_invoice_left">
              <p class="tm_mb2">
                <b class="tm_primary_color">Invoice To:</b>
              </p>
              <p>
                <?php echo $invoice['Nama_Pelanggan']; ?> <br />
                <?php echo $invoice['Alamat_Pelanggan']; ?> <br />
                <?php echo $invoice['NoTelp_Pelanggan']; ?> <br />
                <?php echo $invoice['Email_Pelanggan']; ?>
              </p>
            </div>
            <div class="tm_invoice_right">
              <p class="tm_mb2"><b class="tm_primary_color">Pay To:</b></p>
              <p>
                Laralink Ltd <br />
                86-90 Paul Street, London<br />
                England EC2A 4NE <br />
                demo@gmail.com
              </p>
            </div>
          </div>
          <div class="tm_table tm_style1 tm_mb30">
            <div class="">
              <div class="tm_table_responsive">
                <table>
                  <thead>
                    <tr>
                      <th class="tm_width_3 tm_medium tm_white_color tm_accent_bg">
                        Produk
                      </th>
                      <th class="tm_width_2 tm_medium tm_white_color tm_accent_bg">
                        Sub-Harga
                      </th>
                      <th class="tm_width_2 tm_medium tm_white_color tm_accent_bg">
                        Diskon
                      </th>
                      <th class="tm_width_1 tm_medium tm_white_color tm_accent_bg">
                        Harga
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while ($detailinvoice = mysqli_fetch_array($data)) { ?>
                      <tr>
                        <td class="tm_width_3">
                          <?php echo $detailinvoice['Nama_Produk']; ?>
                        </td>
                        <td class="tm_width_2">
                          <?php echo rupiah($detailinvoice['Harga_Jual']); ?>
                        </td>
                        <td class="tm_width_2">-
                          <?php echo rupiah($detailinvoice['Total_Diskon']); ?>
                        </td>
                        <td class="tm_width_2">
                          <?php echo rupiah($detailinvoice['Harga_Promo']); ?>
                        </td>
                      </tr>
                    <?php }
                    ; ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tm_invoice_footer">
              <div class="tm_left_footer">
                <p class="tm_mb2">
                  <b class="tm_primary_color">Payment info:</b>
                </p>
                <p class="tm_m0">
                  Credit Card - 236***********928 <br />Amount: $1732
                </p>
              </div>
              <div class="tm_right_footer">
                <table>
                  <tbody>
                    <tr>
                      <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">
                        Subtotal
                      </td>
                      <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">
                        <?php echo rupiah($invoice['Subtotal']); ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">
                        Diskon <span class="tm_ternary_color">(
                          <?php echo $invoice['Diskon']; ?>%)
                        </span>
                      </td>
                      <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">
                        -
                        <?php echo rupiah($invoice['Total_Diskon']); ?>
                      </td>

                    </tr>
                    <tr>
                      <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">
                        Pajak <span class="tm_ternary_color">(
                          <?php echo $invoice['Pajak']; ?>%)
                        </span>
                      </td>
                      <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">
                        +
                        <?php echo rupiah($invoice['Total_Pajak']); ?>
                      </td>

                    </tr>
                    <tr class="tm_border_top">
                      <td class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_primary_color">
                        Grand Total
                      </td>
                      <td class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_primary_color tm_text_right">
                        <?php echo rupiah($invoice['Total']); ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="tm_shape_3 tm_accent_bg_10"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tm_invoice_btns tm_hide_print">
        <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
          <span class="tm_btn_icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
              <path
                d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24"
                fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
              <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor"
                stroke-linejoin="round" stroke-width="32" />
              <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none"
                stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
              <circle cx="392" cy="184" r="24" fill="currentColor" />
            </svg>
          </span>
          <span class="tm_btn_text">Print</span>
        </a>
        <button id="tm_download_btn" class="tm_invoice_btn tm_color2">
          <span class="tm_btn_icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
              <path
                d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03"
                fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
            </svg>
          </span>
          <span class="tm_btn_text">Download</span>
        </button>
      </div>
    </div>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/jspdf.min.js"></script>
  <script src="js/html2canvas.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>