<html>
  <head>
    <title>Places Search Box</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYhCrtxpRpGJ05J1T20H2hrEaQsfaClY4&callback=initMap&libraries=places,geometry" async defer></script>
    <style>
    /* スタイルを適用するためのCSS */
    .controls {
      margin: 10px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
      background-color: #f9f9f9;
      width: 300px;
      box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
    }
    .controls::placeholder {
      color: #aaa;
    }
  </style>
  </head>
  <body>
    <input
      id="pac-input"
      class="controls"
      type="text"
      placeholder="Search Box"
    />
    

    <div id="map"></div>
    <div id="info-box"></div>

    <!-- 
      The `defer` attribute causes the callback to execute after the full HTML
      document has been parsed. For non-blocking uses, avoiding race conditions,
      and consistent behavior across browsers, consider loading using Promises.
      See https://developers.google.com/maps/documentation/javascript/load-maps-js-api
      for more information.
      -->
    <script>

function initMap() {
    const map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 34.68954, lng: 135.52537 },
        zoom: 12,
        mapTypeId: "roadmap",
    });
    // Create the search box and link it to the UI element.
    const input = document.getElementById("pac-input");
    const searchBox = new google.maps.places.SearchBox(input);

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    // Bias the SearchBox results towards current map's viewport.
    map.addListener("bounds_changed", () => {
        searchBox.setBounds(map.getBounds());
    });


    
    

    let markers = [];
    searchBox.addListener("places_changed", () => {
    ////"place_chaged"イベントはAutoCompleteクラスのイベント.
    ////https://developers.google.com/maps/documentation/javascript/reference/places-widget#Autocomplete.place_changed

        const places = searchBox.getPlaces();
        ////"getPlaces"メソッドはクエリ(検索キーワード)を配列(PlaceResult)で返す。
        ////https://developers.google.com/maps/documentation/javascript/reference/places-widget#Autocomplete.place_changed

        if (places.length == 0) {
        return;
        }
        // Clear out the old markers.
        markers.forEach((marker) => {
        //"forEach"メソッドは引数にある関数へ、Mapオブジェクトのキー/値を順に代入･関数の実行をする。
            //Mapオブジェクト:
            //https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Map
        marker.setMap(null);
        ////setMapメソッドはMarker(Polyline,Circleなど)クラスのメソッド。Markerを指定した位置に配置する。引数nullにすると地図から取り除く。
        });
        markers = [];
        // For each place, get the icon, name and location.
        const bounds = new google.maps.LatLngBounds();
        ////"LatLngBounds"クラスは境界を作るインスンタンスを作成。引数は左下、右上の座標。
        ////https://lab.syncer.jp/Web/API/Google_Maps/JavaScript/LatLngBounds/#:~:text=LatLngBounds%E3%82%AF%E3%83%A9%E3%82%B9%E3%81%AF%E5%A2%83%E7%95%8C(Bounding,%E4%BD%9C%E3%82%8B%E3%81%93%E3%81%A8%E3%82%82%E3%81%A7%E3%81%8D%E3%81%BE%E3%81%99%E3%80%82
        places.forEach((place) => {
        if (!place.geometry) {
            ////"geometry"はplaceライブラリのメソッド。

            console.log("Returned place contains no geometry");
            return;
        }
        const icon = {
            url: place.icon,
            ////"icon"はアイコンを表すオブジェクト。マーカーをオリジナル画像にしたいときなど。
            ////https://lab.syncer.jp/Web/API/Google_Maps/JavaScript/Icon/
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            ////"Point"クラスはマーカーのラベルなどの位置を決めるインスタンスメソッド。
            ////https://lab.syncer.jp/Web/API/Google_Maps/JavaScript/Point/

            scaledSize: new google.maps.Size(25, 25),
        };
        // Create a marker for each place.
        markers.push(
            new google.maps.Marker({
            map,
            icon,
            title: place.name,
            position: place.geometry.location,
            })
        );

        if (place.geometry.viewport) {
            ////viewport"メソッド
            // Only geocodes have viewport.
            bounds.union(place.geometry.viewport);
            ////"union"メソッドはLatLngBoundsクラスのメソッド。自身の境界に指定した境界を取り込んで合成する。
            ////https://lab.syncer.jp/Web/API/Google_Maps/JavaScript/LatLngBounds/union/
        } else {
            bounds.extend(place.geometry.location);
            ////"extend"メソッドはLatLngBoundsクラスのメソッド。自身の境界に新しく位置座標を追加する。
            ////https://lab.syncer.jp/Web/API/Google_Maps/JavaScript/LatLngBounds/extend/
        }
        });
        map.fitBounds(bounds);
        ////"fitBounds"メソッドはmapクラスのメソッド。指定した境界を見えやすい位置にビューポートを変更する。
        ////https://lab.syncer.jp/Web/API/Google_Maps/JavaScript/Map/fitBounds/#:~:text=Map.fitBounds()%E3%81%AFMap,%E5%A4%89%E6%9B%B4%E3%81%97%E3%81%A6%E3%81%8F%E3%82%8C%E3%81%BE%E3%81%99%E3%80%82

    




        
            // 新しい境界ボックスの中心座標を計算
            const center = bounds.getCenter();

            // 直径30kmの境界ボックスの4つの角の座標を計算
            const northEast = google.maps.geometry.spherical.computeOffset(center, 15000, 45);
            const southWest = google.maps.geometry.spherical.computeOffset(center, 15000, 225);

            // 地図のズーム度合いを計算した境界ボックスに合わせる
            const newBounds = new google.maps.LatLngBounds(southWest, northEast);
            map.fitBounds(newBounds);

    });
    

  const iconBase =
        "https://developers.google.com/maps/documentation/javascript/examples/full/images/";
    const icons = {
        park: {
            icon: iconBase + "park_maps.png",
        },
        hotel: {
            icon: iconBase + "hotel_maps.png",
        },
        restaurant: {
            icon: iconBase + "restaurant_maps.png",
        },
        supermarket: {
            icon: iconBase + "supermarket_maps.png",
        },

        leisure: {
            icon: iconBase + "leisure_maps.png",
        },
        campground: {
            icon: iconBase + "campground_maps.png",
        },
        water: {
            icon: iconBase + "water_maps.png",
        },
        other: {
            icon: iconBase + "other_maps.png",
        },
    };

    
        const features = <?= json_encode($institutions) ?>;
    
        for (let i = 0; i < features.length; i++) {
        const feature = features[i];
        const position = new google.maps.LatLng(feature.latitude, feature.longitude);
        const type = feature.category;
        const content = feature.name; // 例として施設名をcontentに設定

        // ここでマーカーを作成し、地図に配置する処理を行う
        const marker = new google.maps.Marker({
            position: position,
            icon: icons[feature.category], // カテゴリーに対応するアイコンを指定
            map: map,
        });

        const infowindow = new google.maps.InfoWindow({
        content: `
            <div>
                <h3>${feature.name}</h3>
                <p>住所: ${feature.address}</p>
                <p>電話番号: ${feature.tel}</p>
                <p>カテゴリー: ${feature.category}</p>
                ${feature.photos ? `<img src="photos/${feature.photos}" alt="施設写真">` : ''}
            </div>
        `,
        maxWidth: 500,
        ariaLabel: "Info Window " + feature.id,
        });


        marker.addListener("click", () => {
        infowindow.open(map, marker);
        

        
        

        });
    
    }

}

window.initMap = initMap;



</script>
  </body>
</html>









