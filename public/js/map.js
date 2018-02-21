 // General parameters

 var mapStyle = [{
        'stylers': [{ 'visibility': 'off' }]
    }, {
        'featureType': 'landscape',
        'elementType': 'geometry',
        'stylers': [{ 'visibility': 'on' }, { 'color': '#fcfcfc' }]
    }, {
        'featureType': 'water',
        'elementType': 'geometry',
        'stylers': [{ 'visibility': 'on' }, { 'color': '#bfd4ff' }]
    }];
    var map;
    var mapMin = Number.MAX_VALUE,
        mapMax = -Number.MAX_VALUE;

// initialize or start the map
    function initMap() {

        // load the map
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: -6.917959, lng: 107.643644},
            zoom: 12,
            styles: mapStyle
        });


        // set up the style rules and events for google.maps.Data
        map.data.setStyle(styleFeature);
        map.data.addListener('mouseover', mouseInToRegion);
        map.data.addListener('mouseout', mouseOutOfRegion);

        // wire up the button
        var selectBox = document.getElementById('map-variable');
        google.maps.event.addDomListener(selectBox, 'change', function() {
            clearmapData();
            loadmapData(selectBox.options[selectBox.selectedIndex].value);
        });

        // KECAMATAN polygons only need to be loaded once, do them now
        loadMapShapes();

    }

    /** Loads the KECAMATAN boundary polygons from a GeoJSON source. */
    function loadMapShapes() {
        // load KECAMATAN outline polygons from a GeoJson file, have the kecamatan be the ID
        map.data.loadGeoJson('geojson/kota-bandung-level-kecamatan.json', { idPropertyName: 'KECAMATAN' });

        // wait for the request to complete by listening for the first feature to be
        // added
        google.maps.event.addListenerOnce(map.data, 'addfeature', function() {
            google.maps.event.trigger(document.getElementById('map-variable'),
                'change');
        });
    }

    /**
     * Loads the map data from API. 
     * This is what needs to be custom to work from BIRMS
     *
     * @param {string} variable that tells to load the count or the value
     */
    function loadmapData(variable) {
       
        // load the requested variable from the map API
        var xhr = new XMLHttpRequest();
        
        var dt = new Date();
        curryear = dt.getFullYear() - 1;

        // based on the variable (value or count, we load a separate json or api endpoint)
        //xhr.open('GET', 'geojson/' + variable + '.json'); // here this needs to be updated to birms api
        //console.log(curryear);
        curryear = 2016;
        xhr.open('GET', 'api/kecamatan/' + variable + '/'+ curryear); // here this needs to be updated to birms api
        xhr.onload = function() {

            var mapData = JSON.parse(xhr.responseText);
            console.log(mapData);

            // mapData.shift(); // the first row contains column names
            for (i=0; i<mapData.length; i++) {


             
                var mapVariable = parseFloat(mapData[i].summary+1000);
                var KECAMATANId = mapData[i].kecamatan;

                // keep track of min and max values in order to know how to color
                if (mapVariable < mapMin) {
                    mapMin = mapVariable;
                }
                if (mapVariable > mapMax) {
                    mapMax = mapVariable;
                }

                // link the geojson to the value from API by using KECAMATAN as identifier
                map.data
                    .getFeatureById(KECAMATANId)
                    .setProperty('map_variable', mapVariable);
             
               }

            // update and display the legend
            document.getElementById('map-min').textContent =
                mapMin.toLocaleString();
            document.getElementById('map-max').textContent =
                mapMax.toLocaleString();
        };
        xhr.send();
    }

    /** Removes map data from each shape on the map and resets the UI. */
    function clearmapData() {
        mapMin = Number.MAX_VALUE;
        mapMax = -Number.MAX_VALUE;
        map.data.forEach(function(row) {
            row.setProperty('map_variable', undefined);
        });
        document.getElementById('data-box').style.display = 'none';
        document.getElementById('data-caret').style.display = 'none';
    }

    /**
     * Applies a gradient style based on the 'map_variable' column.
     * This is the callback passed to data.setStyle() and is called for each row in
     * the data set.  Check out the docs for Data.StylingFunction.
     *
     * @param {google.maps.Data.Feature} feature
     */
    function styleFeature(feature) {
        // colors
        // Go to photoshop or online hex to HSL converter
        // and get the HSL value
        var low = [107, 19, 89]; // color of smallest datum
        var high = [209, 85, 39]; // color of largest datum

        // delta represents where the value sits between the min and max
        var delta = (feature.getProperty('map_variable') - mapMin) /
            (mapMax - mapMin);

        var color = [];
        for (var i = 0; i < 3; i++) {
            // calculate an integer color based on the delta
            color[i] = (high[i] - low[i]) * delta + low[i];

        }

        // test for null and empty to determine whether to show this shape or not
        var showRow = true;
        if (feature.getProperty('map_variable') == null ||
            isNaN(feature.getProperty('map_variable'))) {
            color[0] = 0;
            color[1] = 0;
            color[2] = 97;    
            showRow = true;
        }

        var outlineWeight = 1,
            zIndex = 1;
        if (feature.getProperty('KECAMATAN') === 'hover') {
            outlineWeight = zIndex = 2;
        }

        return {
            strokeWeight: outlineWeight,
            strokeColor: '#000',
            zIndex: zIndex,
            fillColor: 'hsl(' + color[0] + ',' + color[1] + '%,' + color[2] + '%)',
            fillOpacity: 0.75,
            visible: showRow //visibility flag
        };
    }

    /**
     * Responds to the mouse-in event on a map shape (KECAMATAN).
     *
     * @param {?google.maps.MouseEvent} e
     */
    function mouseInToRegion(e) {
        // set the hover KECAMATAN so the setStyle function can change the border
        e.feature.setProperty('KECAMATAN', 'hover');

        var percent = (e.feature.getProperty('map_variable') - mapMin) /
            (mapMax - mapMin) * 100;

        // update the label
        document.getElementById('data-value').textContent =
            e.feature.getProperty('map_variable').toLocaleString();
        document.getElementById('data-box').style.display = 'block';
        document.getElementById('data-caret').style.display = 'block';
        //move the indicator or caret on the green/blue scale
        document.getElementById('data-caret').style.paddingLeft = percent + '%';
    }

    /**
     * Responds to the mouse-out event on a map shape (KECAMATAN).
     *
     * @param {?google.maps.MouseEvent} e
     */
    function mouseOutOfRegion(e) {
        // reset the hover KECAMATAN, returning the border to normal
        e.feature.setProperty('KECAMATAN', 'normal');
    }