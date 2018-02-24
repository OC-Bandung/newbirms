<section>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-12">
                    <div class="mdc-typography--headline">@lang('homepage.procurement_map_title')
                    </div>
                    <div class="mdc-typography--body1">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat.
                    </div>
                </div>
                
                <div class="mdc-layout-grid__cell--span-8">
                     
                         <div id="map"></div>
                </div> 
                   

                <div class="mdc-layout-grid__cell--span-4">
                    <div id="map-controls">
                        <div id="filter">
                            <div class="mdc-typography--title">@lang('homepage.show_contract_by')</div>
                            <span>
                                <select class="padding-top-small" id="map-variable">
                                    <option value="count">Jumlah Paket Pekerjaan</option>
                                    <option value="value">Pagu Anggaran</option>
                                </select>
                            </span>
                        </div>
                        
                    </div>

                    <div id="data-box" class="margin-top-large ">
                       
                       <div class="even  padding-small"> 
                            <label id="data-label" for="data-value"></label>
                            <div class="mdc-typography--title ">
                                <div> Nilai kontrak </div>  
                                <div id="data-value"></div>
                            </div>

                            <a href="#"><u>View List</u></a> | <a href="#"><u>Access data</u></a>

                        </div>
 
                        <br><br>
                      
                        <div id="legend">
                            <div id="map-min">Min</div>
                            <div class="color-key"><span id="data-caret">&#x25c6;</span></div>
                            <div id="map-max" class="padding-right-small">Maks</div>
                        </div>
                    

                        <div class="text-center margin-top-large">
                            
                            <div class="mdc-typography--title">% OF TOTAL</div>
                                
                            <div class="pie"> </div>
                        </div>
                    </div> 


                </div>   

                
                
                </div>
            </div>
        </div>
    </section>