<section>
        <div class="mdc-layout-grid procurement-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-12">
                    <div class="mdc-typography--headline f300">@lang('homepage.procurement_title')</div>
                </div>
                <div class="mdc-layout-grid__cell--span-3 ">
                    <ul id="load_recent-procurement" class="mdc-list mdc-list--two-line sticky">
                        <li id="load_perencanaan" class="mdc-list-item list-planning active">
                            <span class="mdc-list-item__text">
                                <a href="#">@lang('homepage.planning_title')</a>
                                <span class="mdc-list-item__secondary-text">@lang('homepage.planning_shortdesc')</span>
                            </span>
                        </li>
                        <li id="load_pengadaan" class="mdc-list-item  list-tender  ">
                            <span class="mdc-list-item__text">
                                <a href="#">@lang('homepage.tender_title')</a>
                                <span class="mdc-list-item__secondary-text">@lang('homepage.tender_shortdesc')</span>
                            </span>
                        </li>
                        <li id="load_pemenang" class="mdc-list-item list-award">
                            <span class="mdc-list-item__text">
                                <a href="#">@lang('homepage.award_title')</a>
                                <span class="mdc-list-item__secondary-text">@lang('homepage.award_shortdesc')</span>
                            </span>
                        </li>
                        <li id="load_kontrak" class="mdc-list-item   list-contract">
                            <span class="mdc-list-item__text">
                                <a href="#">@lang('homepage.contract_title')</a>
                                <span class="mdc-list-item__secondary-text">@lang('homepage.contract_shortdesc')</span>
                            </span>
                        </li>
                       <!--  <li id="load_implementasi" class="mdc-list-item list-implementation">
                            <span class="mdc-list-item__text">
                                <a href="#">@lang('homepage.implementation_title')</a>
                                <span class="mdc-list-item__secondary-text">@lang('homepage.implementation_shortdesc')</span>
                            </span>
                        </li> -->
                    </ul>
                </div>
                <div class="mdc-layout-grid__cell--span-9">
                    <div class="">
                        <span id="recent_procurement_title" class="mdc-typography--headline f300"></span> 
                         <div class="pull-right"> 

                            <a id="open-data-planning" target="_blank" href="https://birms.bandung.go.id/beta/api/v1/recent/perencanaan.json"><i class="material-icons">code</i> <span class="mdc-typography--caption vertical-align-top">json</span></a> 
                            
                            <a href="#"><i class="material-icons">sort</i></a>  Sort by: Recent


                        </div>
                    </div>
                    <div id="recent-from-api">
                    </div>
                    <div class="mdc-card procurement-card text-center">
                        <section class="mdc-card__primary">
                            <button class="mdc-button">view more</button>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>