@extends('frontend.layouts.main')

@section('header')
    @include('frontend.layouts.nav')
@endsection

@section('content')

<section class="bg-primary inner-image-banner">
    <div class="container">
      <div class="row pt-3 pb-5">
        <div class="col">
          <div class="text-white">
            <div id="ocid" class="h6 d-inline-block"></div>
            <i data-placement="right" data-toggle="tooltip" data-original-title="ID Open Contracting" class="material-icons small">info</i>
          </div>
          <div class="text-white">
            <div id="page-title" class="h3 d-inline-block"> </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container mt-5">
      <div class="row">
        <div class="col">
          <h6>Tahapan</h6>
          <h5 id="stage" class="text-capitalize"></h5>
        </div>
        <div class="col" data-placement="left" data-toggle="tooltip" data-original-title="Tanggal Rencana Pengadaan">
          <h6 class="d-inline">Tanggal</h6>
          <i class="material-icons small">info</i>
          <h5 id="ocdate"></h5>
        </div>
        <div class="col float-right  h6  float-right">
          <!--<div class="text-right text-uppercase"><a target="_blank" href="#">email</a></div>-->
          <div class="text-right text-uppercase"><a id="oc-json" target="_blank" href="#">json</a></div>
          <div  class="float-right text-right">
            <div>
              <a  id="add-to-watchlist" target="_blank" href="#"><i class="material-icons small">add_box</i> ke daftar</a>
            </div>
            <div>
              <ul id="notificationList"  class="list-group d-none">
                <li id="list-group-item-sample" class="list-group-item"></li>
                <li  data-toggle="modal" data-target="#addNewList" class="list-group-item bg-light text-dark list-group-item-label"><a href="#">Create a new List</a></li>
                <li  data-toggle="modal"  class="list-group-item bg-light text-dark list-group-item-label"><a href="{{ url('watched') }}">Manage lists</a></li>
              </ul>
            </div>
          </div>
          <!-- Modal -->
        <div class="modal fade" id="addNewList" tabindex="-1" role="dialog" aria-labelledby="addNewList" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Buat daftar baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div  id="watch-list-input-container">
                  <div class="alert alert-danger d-none" role="alert">
                      Daftar pengadaan tersebut sudah ada, silahkan pilih yang lainnya.
                    </div>
                 </div>

                  <div class="form-group">
                    <label for="list-name" class="col-form-label">Daftar Pengadaan:</label>
                    <input id="watch-list-name" autofocus type="text" autocomplete="off"  class="form-control">
                  </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button id="addNewList-submit" type="button" class="btn btn-primary">Simpan Perubahan</button>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Progress timeline -->
  <section class="d-none">
    <div class="container pt-5 ">
      <div class="row">
        <div class="col-12">
          <span class="h5">Progress Timeline</span>
          <div class="float-right">
            <ul class="list-inline">
              <li class="icons padding-right-large"><img src="img/icon-on-time.png" alt="on-time"> <span> On Time </span></li>
              <li class="icons padding-right-large"><img src="img/icon-late.png" alt="late"> <span>  Late </span></li>
              <li class="icons padding-right-large"><img src="img/icon-next-milestone.png" alt="next milestone"> <span> Next Milestone </span></li>
            </ul>
          </div>
        </div>
        <div class="col-12">
          <ul class="list-inline">
            <li class="padding-right-large">
              <a href="#planning"> <img src="img/icon-arrow-down.png" alt="down arrow"> <span class="mdc-typography--title"> Perencanaan </span></a>
            </li>
            <li class="tender-stage hidden padding-right-large">
              <a href="#tender"> <img src="img/icon-arrow-down.png" alt="down arrow"> <span class="mdc-typography--title"> Pengadaan </span> </a>
            </li>
            <li class="awards-stage hidden padding-right-large">
              <a href="#award"> <img src="img/icon-arrow-down.png" alt="down arrow"> <span class="mdc-typography--title"> Pemenang </span> </a>
            </li>
            <li class="contract-stage hidden padding-right-large">
              <a href="#contract"> <img src="img/icon-arrow-down.png" alt="down arrow"> <span class="mdc-typography--title"> Kontrak </span></a>
            </li>
            <li class="implementation-stage hidden padding-right-large">
              <a href="#implementation"><img src="img/icon-arrow-down.png" alt="down arrow"> <span class="mdc-typography--title"> Implementasi </span></a>
            </li>
          </ul>
        </div>
        <div class="col-12">
          <div>
            <ul class="timeline" id="main-timeline"> </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <hr>

  <section>
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="row pb-2 pt-3">
            <div class="col">
              <h3>Perencanaan</h3>
            </div>
          </div>
          <div class="card card-border-planning">
            <div class="card-body">
              <div class="row">

                <div class="col-3 pt-2">
                  <h6>Sumber Dana</h6>
                  <h5 id="planning-budget-description" class="text-capitalize">Budget Code</h5>
                </div>

                <div id="planning-budget-amount-container" class="col-3 pt-2">
                  <h6>Pagu Anggaran</h6>
                  <span class="h5">Rp</span>
                  <span class="h3" id="planning-budget-amount-amount"></span>
                  <span class="h5"></span>
                </div>

                <div id="planning-budget-year-container" class="col-3 pt-2 d-none">
                  <h6>Tahun Anggaran</h6>
                  <h5 id="planning-budget-year" class="text-capitalize">Budget Year</h5>
                </div>

                <div id="planning-budget-id-container" class="col-3 pt-2 d-none">
                  <h6>Kode Rekening</h6>
                  <h5 id="planning-budget-id" class="text-capitalize"></h5>
                </div>

                <div id="planning-budget-project-name-container" class="col-5  pt-2">
                  <h6>Project Name</h6>
                  <h5 id="planning-budget-project-name" class="text-capitalize">Project Name</h5>
                </div>

                <div id="parties-buyer-container" class="col-6 pt-4 ">
                  <h6>SKPD</h6>
                  <h5 id="parties-buyer-name" class="text-capitalize"></h5>
                </div>

                <div id="parties-address-buyer-container" class="col-6 pt-4">
                  <h6>Alamat SKPD</h6>
                  <h5 id="parties-buyer-address" class="text-capitalize"></h5>
                </div>

                <div id="parties-proc-container" class="col-6 pt-4  d-none">
                  <h6>Procuring Entity</h6>
                  <h5 id="parties-proc-name" class="text-capitalize"></h5>
                </div>

                <div id="parties-address-proc-container" class="col-6 pt-4 d-none">
                  <h6>Procuring Entity Address</h6>
                  <h5 id="parties-proc-address" class="text-capitalize"></h5>
                </div>

                <div id="parties-rationale-container" class="col-12 pt-4 d-none">
                  <h6>Rationale*</h6>
                  <p id="parties-proc-rationale" class="text-capitalize">Berkembangnya ekonomi kreatif untuk mendukung tercapainya Bandung sebagai Kota Kreatif.</p>
                </div>
              </div>
                <!-- end of col -->
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>



  <section id="tender-section" class="d-none mt-5">

    <div class="container">
      <div class="row pb-2 pt-3">
        <div class="col">
          <span class="h3">Pengadaan</span> <span id="tender-status-container" class="h6 ml-3"> <i class="material-icons">outlined_flag</i>status: <span id="tender-status"></span></span>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <ul class="nav nav-tabs card-border-tender " id="tenderTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active border-left-0" id="tender-details-tab" data-toggle="tab" href="#tender-details" role="tab" aria-controls="tender-details" aria-selected="true">Detail</a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-none" id="tender-milestones-tab" data-toggle="tab" href="#tender-milestones" role="tab" aria-controls="tender-milestones" aria-selected="false">Tahap Pengadaan <sup id="tender-milestone-count">()</sup></a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-none" id="tender-registered-bidders-tab" data-toggle="tab" href="#tender-registered-bidders" role="tab" aria-controls="tender-registered-bidders" aria-selected="false">Peserta Terdaftar <sup id="tender-registered-bidders-counter">()</sup></a>
            </li>
            <!--<li class="nav-item">
              <a class="nav-link" id="tender-help-tab" data-toggle="tab" href="#tender-help" role="tab" aria-controls="tender-help" aria-selected="false">Engagement Stats</a>
            </li>-->
          </ul>
          <div class="tab-content" id="tenderTabContent">
            <div class="tab-pane fade show active" id="tender-details" role="tabpanel" aria-labelledby="tender-details-tab">
              <div class="row">
                <div class="col">
                  <div class="card rounded-0 border-top-0 card-border-tender">
                    <div class="card-body">
                      <div class="row ">
                        <div id="tender-mainProcurementCategory-container" class="col d-none pt-3">
                          <h6>Klasifikasi Pengadaan</h6>
                          <h5 id="tender-mainProcurementCategory" class="text-capitalize"></h5>
                        </div>

                        <div id="tender-procurementMethod-container" class="col d-none pt-3">
                          <h6>Metode Pengadaan</h6>
                          <h5 id="tender-procurementMethod" class="text-capitalize"></h5>
                        </div>

                        <div id="tender-numberOfTenderers-container" class="col d-none text-center pt-3">
                          <h6># Peserta</h6>
                          <h5 id="tender-numberOfTenderers" class="text-capitalize"></h5>
                        </div>

                        <div id="tender-awardCriteria-container" class="col d-none pt-3">
                          <h6>Award Criteria*</h6>
                          <h5 id="tender-awardCriteria" class="text-capitalize">PriceOnly</h5>
                        </div>
                      </div>
                      <div class="row mt-5">
                        <div class="col">
                          <div id="tender-tenderPeriod-startDate-container" class="col-12 border-left">
                            <div data-toggle="tooltip" title="The period when the tender is open for submissions.">
                              <h6>Tender Mulai <i class="material-icons small lightgray">info</i></h6>
                              <h5 id="tender-tenderPeriod-startDate" class="text-capitalize mb-0"></h5>
                            </div>
                          </div>
                          <div class="col-12 text-center pr-3 pt-3 pb-3 small border-left">
                            <ul class="list-group w-75 list-group-flush">
                              <li id="tender-tender-days-diff-container" class="list-group-item d-none p-2 d-flex justify-content-between align-items-center">
                                <span id="tender-tender-days-diff"></span>
                              </li>
                              <li class="list-group-item  p-2 d-flex justify-content-between align-items-center">
                              <a href="#" id="tender-tenderPeriod-add" target="_blank" rel="nofollow"><i class="material-icons small">add_box</i> tambahkan ke kalender</a>
                              </li>
                            </ul>
                          </div>
                          <div id="tender-tenderPeriod-endDate-container" class="col-12 border-left">
                            <div class="">
                              <h6>Tender Selesai <i class="material-icons small">info</i></h6>
                              <h5 id="tender-tenderPeriod-endDate" class="text-capitalize "></h5>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="col-12 ">
                            <div class="row">
                              <div id="tender-contractPeriod-startDate-container" class="col-12 border-left">
                                <div>
                                  <h6>Estimasi Pekerjaan Mulai <i class="material-icons small">info</i></h6>
                                  <h5 id="tender-contractPeriod-startDate" class="text-capitalize"></h5>
                                </div>
                              </div>
                              <div class="col-12  border-left">
                                <ul class="list-group small pr-3 pt-3 pb-3  w-75 list-group-flush">
                                  <li id="tender-contract-days-diff" class="list-group-item p-2 d-flex justify-content-between align-items-center"></li>
                                  <li class="list-group-item p-2 d-flex justify-content-between align-items-center">
                                  <a href="#" id="tender-contractPeriod-add" target="_blank" rel="nofollow"><i class="material-icons small">add_box</i> tambahkan ke kalender</a>
                                  </li>
                                </ul>
                              </div>
                              <div id="tender-contractPeriod-endDate-container" class="col-12 border-left">
                                <div>
                                  <h6>Estimasi Pekerjaan Selesai <i class="material-icons small">info</i></h6>
                                  <h5 id="tender-contractPeriod-endDate" class="text-capitalize"></h5>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="col-12 ">
                            <div class="row">
                              <div id="tender-budget-amount-container" class="col-12  d-none border-left">
                                <div>
                                  <h6>Pagu Anggaran <i class="material-icons small">info</i></h6>
                                  <span class="h5 pr-1">Rp. </span> <span class="h4" id="tender-budget-amount"></span>
                                </div>
                              </div>
                              <div id="tender-value-diff-container" class="col-12 d-none border-left">
                                <ul class="list-group small pr-3 pt-3 pb-3  w-75 list-group-flush">
                                  <li class="list-group-item p-2 d-flex align-items-center">
                                    <span class="pr-1">Rp. </span> <span id="tender-value-diff"></span>
                                  </li>
                                  <li id="tender-amount-flag" class="list-group-item p-2 d-flex "> </li>
                                </ul>
                              </div>
                              <div id="tender-value-amount-container" class="col-12 d-none border-left">
                                <!-- The total upper estimated value of the procurement -->
                                <div>
                                  <h6> Nilai Penawaran <i class="material-icons small">info</i></h6>
                                  <div>
                                      <span class="h5">Rp.</span>
                                      <span class="h4" id="tender-value-amount"> </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-5">
                        <div class="col">
                          <h6>Dokumen & Link</h6>
                          <dl class="small">
                            <dt>SIRUP Links</dt>
                            <dd>Lihat Data asli dari sirup di <a href="#" id="sirup-link" target="_blank">sini</a>. </dd>
                            <dt>LPSE Links</dt>
                            <dd>Lihat Data asli dari lpse LKPP di <a href="#" id="lpse-link" target="_blank">sini</a>. </dd>
                            <dt>BIRMS Links</dt>
                            <dd>Lihat Data asli dari BIRMS di <a href="#" id="birms-link" target="_blank">sini</a>. </dd>
                          </dl>
                        </div>
                        <div id="vertical-chart-container" class="col-5 d-none">
                          <ul id="vertical-chart" class="mb-0 ">
                            <li id="expected"></li>
                            <li id="actual"></li>
                          </ul>
                          <div id="tender-value-diff-percentage" class="h6 p-2 text-center bg-light"> </div>
                        </div>
                        <div class="col pt-2  font-weight-light bdg-feedback">
                          <h6 class="mb-5"> Keterlibatan & Pembaruan</h6>
                          <div class="mt-5 ">
                            <a target="_blank" id="bdg-feedback-form" href="#"><small> Bagikan tanggapan anda </small></a>
                          </div>
                          <div class="">
                            <img class="w-25" src="img/icon-conversation.png" alt="Open Contracting">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="tab-pane fade" id="tender-registered-bidders" role="tabpanel" aria-labelledby="tender-registered-bidders-tab">
              <div class="row">
                <div class="col">
                  <div class="card border-top-0 rounded-0 card-border-tender">
                    <div class="card-body">
                      <div class="row font-weight-light">
                        <table class="table">
                          <thead class="thead-dark">
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">NPWP</th>
                              <th scope="col">Nama Peserta</th>
                              <th scope="col">Alamat</th>
                            </tr>
                          </thead>
                          <tbody id="tender-tenderers-list"></tbody>
                        </table>
                        <div class="ml-2 h4" id="navcontainer"> </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="tab-pane fade" id="tender-milestones" role="tabpanel" aria-labelledby="tender-milestones-tab">
              <div class="row">
                <div class="col">
                  <div class="card border-top-0 rounded-0 card-border-tender">
                    <div class="card-body">
                      <div id="tender-milestones-cards" class="row mt-3 font-weight-light"> </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="tender-help" role="tabpanel" aria-labelledby="tender-help-tab">
              <div class="row">
                <div class="col">
                  <div class="card rounded-0 border-top-0 card-border-tender">
                    <div class="card-body">
                      <div class="row ">
                        <p class="p-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                          Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <section id="award-section" class="d-none">
    <div class="container mt-3">
      <div class="row pb-2 pt-3">
        <div class="col">
          <span class="h3">Pemenang & Kontrak</span><span><sup>( <span id="awards-count"> </span> kontrak)</sup>
          </span>
        </div>
      </div>

      <div id="awards-parent-container">

        <div class="card awards-sample-container card-border-award rounded-0 d-none  mt-3">
          <div class="card-body">

            <div class="row">

              <div class="col-5">
                <div class="row">
                  <div class="col-12  awards-id-container d-none">
                    <div class="h6">Award ID #<span class="awards-id h6">20160316.21706.0ce0b</span></div>
                  </div>
                  <div class="col-12 awards-title-container d-none">
                    <div class="awards-title h5"> </div>
                  </div>
                </div>
              </div>

              <div class="col-6">
                <div class="row">
                  <div class="col awards-status-container d-none">
                    <div class="h6">Status</div>
                    <div class="awards-status h5"> </div>
                  </div>
                  <div class="col awards-date-container d-none">
                    <div class="h6">Penetapan Pemenang</div>
                    <div class="awards-date h5"> </div>
                  </div>
                  <div class="col awards-value-amount-container d-none">
                    <div class="h6">Nilai Penawaran</div>
                    <div class="awards-value-amount h5"></div>
                  </div>
                </div>
              </div>

            </div>

            <div class="row">
              <div class="awards-suppliers-parent-container col mt-3"  ></div>

              <div id="awards-suppliers-sample-container" class="row mt-2">
                <div class="col-5 awards-suppliers-id-container d-none">
                  <div class="h6 ">NPWP</div>
                  <div class="awards-suppliers-id h5"> </div>
                </div>
                <div class="col awards-suppliers-name-container d-none ">
                  <div class="h6">Perusahaan Pemenang</div>
                  <div class="awards-suppliers-name h5"> </div>
                </div>
              </div>

            </div>

            <div class="row">
              <div class="col">
                <div class="awards-contracts-parent-container mt-2"> </div>

                <div id="awards-contracts-sample-container" class="ml-3 mt-2">
                  <div class="row">
                    <div class="col-3  pt-1 ">
                      <div class="bg-dark h6 p-2 text-white">KONTRAK</div>
                    </div>
                  </div>
                  <div class="row ">
                    <div class="col-5">
                      <div class="row">
                        <div class="col contracts-value-amount-container d-none">
                          <div class="h6">Nilai Kontrak</div>
                          <div class="contracts-value-amount h5"></div>
                        </div>
                      </div>
                      <div class="row mt-2 d-flex">
                        <div class="col contracts-period-startDate-container d-none">
                          <div class="h6">Tanggal Mulai</div>
                          <div class="contracts-period-startDate h5"> </div>
                        </div>
                        <div class="col contracts-period-endDate-container d-none">
                          <div class="h6">Tanggal Selesai</div>
                          <div class="contracts-period-endDate h5"> </div>
                        </div>
                      </div>
                      <div class="row  mt-2  d-flex">
                        <div class="col contracts-status-container d-none">
                          <div class="h6">Status</div>
                          <div class="contracts-status h5"></div>
                        </div>
                        <div class="col contracts-dateSigned-container d-none">
                          <div class="h6">Tanda Tangan Kontrak</div>
                          <div class="contracts-dateSigned h5"> </div>
                        </div>
                      </div>
                    </div>

                    <div  class="col">
                      <!--<div class="row">
                        <div class="col contracts-items-count-container">
                          <div class="h6">Dokumen Kontrak</div>
                          <div class="h5"> <a href="#">link</a> </div>
                        </div>
                      </div>-->
                      <div class= "contract-items-container">
                      </div>

                    </div>

                  </div>
                </div>
              </div>
            </div>


          </div>

        </div>
      </div>


    </div>
  </section>

@endsection

@section('footer')
  <script type="text/javascript" src="{{ url('js/shared.js') }}"></script>
  <script type="text/javascript" src="{{ url('js/contract/ui.js') }}"></script>

  <!-- a script for each stage  -->
  <script type="text/javascript" src="{{ url('js/contract/data.js') }}"></script>
  <script type="text/javascript" src="{{ url('js/contract/timeline.js') }}"></script>
  <script type="text/javascript" src="{{ url('js/contract/ocds/planning.js') }}"></script>
  <script type="text/javascript" src="{{ url('js/contract/ocds/tender.js') }}"></script>
  <script type="text/javascript" src="{{ url('js/contract/ocds/awards.js') }}"></script>
  <script type="text/javascript" src="{{ url('js/contract/ocds/contracts.js') }}"></script>
  <script type="text/javascript" src="{{ url('js/contract/ocds/implementation.js') }}"></script>
@endsection