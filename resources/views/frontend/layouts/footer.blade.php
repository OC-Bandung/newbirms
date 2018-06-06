	<!--footer-->
	<footer>
        <a href="https://www.bandung.go.id" target="_blank"><img src="{{ url('img/bandung-branding.png') }}"></a>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <script src="{{ url('js/clipboard.min.js') }}"></script>

    <script src="{{ url('js/classie.js') }}"></script>
 
    <script src="{{ url('js/recent.js') }}"></script>
    
    <script src="{{ url('js/search.js') }}"></script>
    <script src="{{ url('js/homepage-slider.js') }}"></script>
    <script src="{{ url('js/ui.js') }}"></script>
    <script src="{{ url('js/moment.min.js') }}"></script>
     
    <script src="{{ url('js/map.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmGnhhccwog6j_hFmAo8zg1VaYWE_m7Ak&callback=initMap"></script>

    <script src="{{ url('js/graph.js') }}"></script>
    <script src="{{ url('js/open-data.js') }}"></script>

    <script>
const menuEls = Array.from(document.querySelectorAll('.mdc-menu'));

menuEls.forEach((menuEl) => {
  // Initialize MDCSimpleMenu on each ".mdc-simple-menu"
  const menu = new mdc.menu.MDCMenu(menuEl);

  // We wrapped menu and toggle into containers for easier selecting the toggles
  const dropdownToggle = menuEl.parentElement.querySelector('.js--dropdown-toggle');
  dropdownToggle.addEventListener('click', () => {
    menu.open = !menu.open;
  });

  menu.setAnchorCorner(mdc.menu.MDCMenuFoundation.Corner.BOTTOM_START);
});

    </script>