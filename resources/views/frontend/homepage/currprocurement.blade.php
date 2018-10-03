<section id="currprocurement">
    <div class="container pt-5">

        <div class="row">
          <div class="col-12">
            <h3>@lang('homepage.procurement_title')</h3>
            <p>@lang('homepage.procurement_shortdesc')</p>
          </div>
        </div>

      <div class="row pt-3">
        <div class="col-3 pr-0">
              <ul id="load_recent-procurement" class="list-recent-proc sticky">

                  <li id="load_perencanaan" class="list-planning active p-3">
                      <span class="d-block">
                          <a class="text-dark no-underline" href="#">
                          <span class="h5">@lang('homepage.planning_title')</span>
                          <span class="d-block">@lang('homepage.planning_shortdesc')</span>
                          </a>
                      </span>
                  </li>
                  <li id="load_pengadaan" class="list-tender p-3 ">
                      <span class=" d-block">
                          <a class="text-dark no-underline" href="#">
                            <span class="h5">@lang('homepage.tender_title')</span>
                            <span class="d-block">@lang('homepage.tender_shortdesc')</span>
                          </a>
                      </span>
                  </li>
                  <li id="load_pemenang" class=" list-award p-3">
                      <span class=" d-block">
                          <a class="text-dark no-underline" href="#">
                            <span class="h5">@lang('homepage.award_title')</span>
                            <span class="d-block">@lang('homepage.award_shortdesc')</span>
                          </a>
                      </span>
                  </li>
                  <li id="load_kontrak" class=" list-contract p-3  ">
                      <span class=" d-block">
                          <a class="text-dark no-underline" href="#">
                            <span class="h5">@lang('homepage.contract_title')</span>
                            <span class="d-block">@lang('homepage.contract_shortdesc')</span>
                          </a>
                      </span>
                  </li>
                 <!--  <li id="load_implementasi" class="mdc-list-item list-implementation">
                      <span class="mdc-list-item__text">
                          <a href="#">Implementasi</a>
                          <span class="mdc-list-item__secondary-text">Progres pekerjaan</span>
                      </span>
                  </li> -->
              </ul>

        </div>

        <div class="col-9 pl-0 ">
            <div id="recent-from-api"> </div>
                <div class="list-group rounded-0">
                </div>
            </div>
        </div>
    </div>
</section>

<div class="mt-5 separator-primary">
   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 40" preserveAspectRatio="none">
     <path d="M 0 19.5573 C 200 19.5573 200 13.9236 400 13.9236 C 600 13.9236 800 26.0764 1000 26.0764 L 1000 50 L 0 50 L 0 19.5573 Z">
       <animate attributeName="d" begin="0s" dur="25s" repeatCount="indefinite" values="
         M0,0 C200,7.11236625e-15 200,40 400,40 C600,40 800,0 1000,0 L1000,50 L0,50 L0,0 Z;
         M0,40 C200,40 400,0 600,0 C800,0 800,40 1000,40 L1000,50 L0,50 L0,40 Z;
         M0,30 C200,30 200,0 400,0 C600,0 800,40 1000,40 L1000,50 L0,50 L0,30 Z;
         M0,0 C200,7.11236625e-15 200,40 400,40 C600,40 800,0 1000,0 L1000,50 L0,50 L0,0 Z;"></animate>
     </path>
   </svg>
 </div>