<section class="mt-5">
  <div class="container mt-5">
    <div class="row mt-3">
      <div class="col mt-3">
        <h3>@lang('homepage.welcome_title')</h3>
        <div align="justify">
        @lang('homepage.welcome_text')
        </div>
        <div class="position-absolute b-5 t-5">
          <a class="hammer text-dark" href="#" data-toggle="modal" data-target="#contactUs">@lang('homepage.about_contactus')</a> | 
          <a class="hammer text-dark" href="#" data-toggle="modal" data-target="#publicationPolicy">@lang('homepage.about_publication')</a> | 
          <a class="hammer text-dark" href="#" data-toggle="modal" data-target="#howtouse">@lang('homepage.about_how_to_use')</a>

          <!-- Modal - Start -->
          <div class="modal fade" id="contactUs" tabindex="-1" role="dialog" aria-labelledby="contactUs" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">@lang('homepage.about_contactus')</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="font-family: Courier New, Courier, monospace; font-size: small;">
     
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal - End -->
          <!-- Modal - Start -->
          <div class="modal fade" id="publicationPolicy" tabindex="-1" role="dialog" aria-labelledby="publicationPolicy" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">@lang('homepage.about_publication')</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="font-family: Courier New, Courier, monospace; font-size: small;">
<p align="center">Bandung Integrated Resources Management System (BIRMS)<br>
Bagian Layanan Pengadaan (BALAP)<br>
Sekretariat Daerah Pemerintah Kota Bandung<br>
----------------------------------------------------------------<br>
<br>
Kebijakan Publikasi<br>
-------------------</p>
<p></p>
<p><strong>Tentang data:</strong></p>
<p>Data pada portal ini mencakup proses pengadaan dan kontrak Kota Bandung yang dilakukan melalui metode pengadaan kompetitif dan non-kompetitif dari tahun 2016 sampai dengan sekarang. Data diambil dari beberapa sistem pengadaan, termasuk: SIRA (e-budgeting), SIMDA (e-finance), SiRUP (e-rencana umum pengadaan), LPSE (e-tender), dan e-Kontrak (rincian kontrak untuk pengadaan non-kompetitif).</p>
<p><strong>Perizinan:</strong></p>
<p>Data tersedia untuk umum di bawah lisensi Creative <a href="https://opendefinition.org/licenses/cc-by-sa" target="_blank">Commons Attribution Share-Alike 4.0 (CC-BY-SA-4.0)</a>. Ini memberikan kebebasan kepada pengguna untuk menjelajahi, mengunduh, memantau dan menggunakan kembali data untuk tujuan apa pun, termasuk pemantauan kontrak, analisis, dan penelitian. Data dimodelkan sesuai dengan <a href="http://standard.open-contracting.org/latest/en/" target="_blank">Open Contracting Data Standard (OCDS)</a>.</p>
<p><strong>Rencana pengembangan ke depan:</strong></p>
<p>Pemerintah Kota Bandung mendorong pengguna dari semua sektor masyarakat (pemerintah, sektor swasta, masyarakat sipil) untuk mengunjungi situs web secara teratur, berlangganan pembaruan tentang peluang tender atau informasi tentang kontrak tertentu, dan memanfaatkan data ini. Pemerintah Kota Bandung berkomitmen untuk meningkatkan kualitas data yang dipublikasikan dari waktu ke waktu, dan menyambut setiap umpan balik dari pengguna tentang kualitas data. Kota Bandung sedang bekerja untuk memperkenalkan data geolokasi paket-paket pengadaan, dan saat ini memprakarsai inisiatif ini pada data 2018. Data geolokasi termasuk dalam dataset dan API 2018, dan juga dapat divisualisasikan pada peta interaktif.</p>
<p><strong>Informasi kontak penerbit:</strong></p>
<p>Jika Anda memiliki pertanyaan, komentar atau ide, silakan hubungi kami. Pertanyaan umum dapat dikirimkan ke <a href="mailto:lpsebandungjuara@gmail.com">lpsebandungjuara@gmail.com</a> atau <a href="mailto:infobirms@bandung.go.id">infobirms@bandung.go.id</a>. Anda dapat berlangganan pembaruan tentang peluang tender dan informasi tentang kontrak tertentu, dan bergabung dengan percakapan online di twitter dengan hashtag <strong>#BDGOpenContracting</strong>.</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal - End -->

          <!-- Modal - Start -->
          <div class="modal fade" id="howtouse" tabindex="-1" role="dialog" aria-labelledby="howtouse" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">@lang('homepage.about_how_to_use')</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <div id="timeline" class="accordion bg-dark color-white" >
              <div class="card timeline-card no-border mt-3 ml-2">
                <div class="card-header timeline-card-header " id="headingOne">
                    <button class="btn btn-link bdg-timeline" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      <h5 class="card-title color-white pl-5">Learn about Bandung City’s open contracting data</h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#timeline">
                  <div class="card-body pt-0 pb-0">
                    <p class="card-text">The data in this portal covers Bandung City’s procurement and contracting processes conducted through both competitive and non-competitive procurement methods for years 2016, 2017 and 2018. It is made available to the public under a <a href="https://creativecommons.org/licenses/by/3.0/" target="_blank">Creative Commons Attribution License (CC-BY)</a>. This grants any user the freedom to explore, download, monitor and re-use the data for any purposes, including contract monitoring, analytics and research. The data is modeled according to the <a href="http://standard.open-contracting.org/latest/en/" target="_blank">Open Contracting Data Standard (OCDS)</a>.</p>
                  </div>
                </div>
              </div>

              <div class="card timeline-card no-border ml-2 pb-3">
                  <div class="card-header timeline-card-header" id="headingTwo">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed bdg-timeline" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <h5 class="card-title color-white  pl-5"> Use the data and get creative</h5>
                      </button>
                    </h5>
                  </div>
                  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#timeline">
                    <div class="card-body pt-0 pb-0">
                      <p class="card-text">Government officials, firms, individual experts, citizens, journalists and developers can all be users of Bandung City’s open contracting data. The data can be visualized online on the BIRMS portal, <a href="https://birms.bandung.go.id/">downloaded</a> in CSV and JSON serialization, or accessed through <a href="https://birms.bandung.go.id/api">Bandung City’s OCDS Application Programming Interface (API)</a>. It can be used for a variety of use cases such as: searching for business opportunities, monitoring procurement processes and public contracts, and carrying out research and analysis.</p>
                    </div>
                  </div>
                </div>

              <div class="card timeline-card no-border ml-2">
                <div class="card-header timeline-card-header" id="headingThree">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                     <h5 class="card-title color-white pl-5">Share your insights and take action</h5>
                    </button>
                  </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#timeline">
                  <div class="card-body pt-0 pb-5">
                    <p class="card-text">If you have questions, comments or ideas, please get in touch with us. General inquiries can be submitted to <a href="mailto:info@birms.bandung.go.id ">info@birms.bandung.go.id</a> or through the online form. You can subscribe to updates on tender opportunities and information on specific contracts, and join the online conversation on twitter with the hashtag #BDGopencontracting.</p>
                  </div>
                </div>
              </div>

            </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal - End -->
          
        </div>
      </div>
    </div>
  </div>
</section>