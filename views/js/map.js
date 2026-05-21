(function () {

    const properties = [
        {
            id:1,
            name:'Villa Rosa',
            type:'house',
            location:'bacolod',
            storey:2,
            bedroom:3,
            tb:2,
            price:'3m',
            lat:10.6713,
            lng:122.9511,
            addr:'Brgy. Taculing, Bacolod City'
        },
        {
            id:2,
            name:'Palm Residences',
            type:'condo',
            location:'bacolod',
            storey:1,
            bedroom:2,
            tb:1,
            price:'1m',
            lat:10.6770,
            lng:122.9380,
            addr:'Lacson St., Bacolod City'
        },
        {
            id:3,
            name:'Sugarland Homes',
            type:'house',
            location:'talisay',
            storey:1,
            bedroom:3,
            tb:2,
            price:'1m',
            lat:10.7400,
            lng:122.9700,
            addr:'Talisay City'
        }
    ];

    const map = L.map('ht-map', {
        center:[10.6713, 122.9511],
        zoom:11
    });

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            attribution:'© OpenStreetMap',
            maxZoom:19
        }
    ).addTo(map);

    const blueIcon = L.divIcon({
        className:'',
        html:`
        <svg xmlns="http://www.w3.org/2000/svg"
             width="28"
             height="38"
             viewBox="0 0 28 38">
            <path fill="#2151cc"
                  stroke="#fff"
                  stroke-width="1.5"
                  d="M14 0C6.27 0 0 6.27 0 14c0 9.63 14 24 14 24S28 23.63 28 14C28 6.27 21.73 0 14 0z"/>
            <circle cx="14" cy="14" r="5" fill="#fff"/>
        </svg>
        `,
        iconSize:[28,38],
        iconAnchor:[14,38],
        popupAnchor:[0,-40]
    });

    let markers = [];

    function addMarkers(list) {

        markers.forEach(m => map.removeLayer(m));
        markers = [];

        list.forEach(p => {

            const marker = L.marker(
                [p.lat, p.lng],
                { icon: blueIcon }
            )
            .bindPopup(`
                <b>${p.name}</b><br>
                <small>${p.addr}</small><br><br>

                Type:
                ${p.type.charAt(0).toUpperCase()+p.type.slice(1)}<br>

                Bedrooms:
                ${p.bedroom || '—'}

                &nbsp;|&nbsp;

                T&B:
                ${p.tb || '—'}<br>

                Price:
                ${p.price}
            `)
            .addTo(map);

            markers.push(marker);
        });

        document.getElementById('result-count').textContent =
            list.length === properties.length
            ? 'Showing all properties'
            : `${list.length} properties found`;
    }

    addMarkers(properties);

    window.filterProperties = function () {

        const v = id => document.getElementById(id).value;

        const filtered = properties.filter(p => {

            if (v('f-type') && p.type !== v('f-type')) return false;

            if (v('f-location') && p.location !== v('f-location')) return false;

            if (v('f-storey') && p.storey !== parseInt(v('f-storey')))
                return false;

            if (v('f-bedroom') && p.bedroom !== parseInt(v('f-bedroom')))
                return false;

            if (v('f-price') && p.price !== v('f-price'))
                return false;

            if (v('f-tb') && p.tb !== parseInt(v('f-tb')))
                return false;

            return true;
        });

        addMarkers(filtered);

        if (filtered.length === 1) {

            map.setView(
                [filtered[0].lat, filtered[0].lng],
                14
            );

        } else if (filtered.length > 1) {

            map.fitBounds(
                L.featureGroup(markers)
                .getBounds()
                .pad(0.2)
            );
        }
    };

    window.clearFilters = function () {

        [
            'f-type',
            'f-location',
            'f-storey',
            'f-bedroom',
            'f-price',
            'f-tb',
            'f-name'
        ].forEach(id => {
            document.getElementById(id).value = '';
        });

        addMarkers(properties);

        map.setView(
            [10.6713, 122.9511],
            11
        );
    };

    window.viewDetails = function () {

        if (markers.length === 1) {
            markers[0].openPopup();
        } else {
            alert(
                'Narrow your search to one property first.'
            );
        }
    };

})();
