<section>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-12">
                    <div class="mdc-typography--headline f300">@lang('homepage.statistic_title')
                    </div>
                    <div class="mdc-typography--body1">
                        @lang('homepage.statistic_description')
                    </div>
                </div>
            </div>
        </div>

        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-card demo-card">
                        <div class="mdc-card__horizontal-block">
                            
                            
                            <div id="graph01" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                            

                            <div class="pull-right  padding-small">
                                <a target="_blank" href="{{ url('api/graph/1') }}"><i class="material-icons">code</i> <span class="mdc-typography--caption vertical-align-top">json</span></a> 

                                <a id="open-data-graph1" href="{{ url('api/graph/csv/1') }}" target="_blank">
                                    <i class="material-icons">description</i> 
                                    <span  class="mdc-typography--caption vertical-align-top">csv</span>
                                </a>
                            </div> 

                        </div>
                    </div>
                </div>

                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-card demo-card">
                         
                        <div class="mdc-card__horizontal-block">
                            <div id="graph02" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                            
                            <div class="pull-right  padding-small">
                                <a target="_blank" href="{{ url('api/graph/2/2017') }}"><i class="material-icons">code</i> <span class="mdc-typography--caption vertical-align-top">json</span></a> 

                                <a href="{{ url('api/graph/csv/2/2017') }}" target="_blank">
                                    <i class="material-icons">description</i> 
                                    <span class="mdc-typography--caption vertical-align-top">csv</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-card demo-card">
                        
                        <div class="mdc-card__horizontal-block">
                            <div id="graph03" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                            
                            <div class="pull-right  padding-small">
                                <a target="_blank" href="{{ url('api/graph/3/2017') }}"><i class="material-icons">code</i> <span class="mdc-typography--caption vertical-align-top">json</span></a> 

                                <a href="{{ url('api/graph/csv/3/2017') }}" target="_blank">
                                    <i class="material-icons">description</i> 
                                    <span class="mdc-typography--caption vertical-align-top">csv</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-card demo-card">
                        
                        <div class="mdc-card__horizontal-block">
                            <div id="graph04" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                            
                            <div class="pull-right  padding-small">
                                <a target="_blank" href="{{ url('api/graph/4') }}"><i class="material-icons">code</i> <span class="mdc-typography--caption vertical-align-top">json</span></a> 

                                <a href="{{ url('api/graph/csv/4') }}" target="_blank">
                                    <i class="material-icons">description</i> 
                                    <span class="mdc-typography--caption vertical-align-top">csv</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>