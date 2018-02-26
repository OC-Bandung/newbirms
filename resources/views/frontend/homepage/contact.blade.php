<section>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-typography--display1"> <span class="color-primary">BIRMS</span><span class="f300">, a truly integrated system </span></div>
                </div>
            </div>
        </div>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-7">
                    <div class="mdc-grid-list">
                        <ul class="mdc-grid-list__tiles">
                            @foreach($app as $rowapp)
                            <li class="mdc-grid-tile">
                                <a href="{{ $rowapp['Link'] }}" title="{{ $rowapp['Title'] }}">
                                <div class="mdc-grid-tile__primary">
                                    <img class="mdc-grid-tile__primary-content" src="{{ url('images/apps/'.$rowapp['Iconimg']) }}" />
                                </div>
                                <span class="mdc-grid-tile__secondary">
                                    <span class="mdc-grid-tile__title">{{ $rowapp['Title'] }}</span>
                                </span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <br>
                    
                </div>
                <div class="mdc-layout-grid__cell--span-4">
                    <div class="mdc-typography--headline">@lang('homepage.contact_title')</div>
                    @lang('homepage.contact_text')
                    <div>
                        <div class="mdc-textfield padding-top-small mdc-textfield--fullwidth">
                            <input class=" mdc-textfield__input" type="text" placeholder="Name" aria-label="Name">
                        </div>
                        <div class=" padding-top-small mdc-textfield mdc-textfield--fullwidth">
                            <input class="mdc-textfield__input" type="text" placeholder="Email" aria-label="Email">
                        </div>
                        <div class="padding-top-small mdc-textfield mdc-textfield--multiline mdc-textfield--fullwidth">
                            <textarea class="padding-top-small mdc-textfield__input" placeholder="Message" rows="8" cols="40" aria-label="Message"></textarea>
                        </div>
                        <br>
                        <button class="mdc-button mdc-button--raised">
                            Send Message
                        </button>
                    </div>
                </div>
            </div>



 <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">

            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-12">
                        <div class="mdc-typography--subheading1"> PARTNERS</span>
                        </div>
                        <a href="http://lkpp.go.id" target="_blank" title="Lembaga Kebijakan Pengadaan Barang/Jasa Pemerintah"><img src="{{ url('images/partners/1lkpp.png') }}"></a>
                        <a href="http://www.bpkp.go.id/konten/433/SIMDA.bpkp" target="_blank" title="Program Aplikasi Komputer SIMDA

"><img src="{{ url('images/partners/2simda.png') }}"></a>
                        <a href="https://www.open-contracting.org" target="_blank" title="Open Contracting Partnership"><img src="{{ url('images/partners/3oc.png') }}"></a>
                        <a href="http://www.worldbank.org" target="_blank" title="World Bank Group"><img src="{{ url('images/partners/2wb.png') }}"></a>
                    </div>
                </div>
            </div>
    </section>