function colorMarker(color) {
    const svgTemplate = `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="marker">
        <path fill-opacity=".25" d="M16 32s1.427-9.585 3.761-12.025c4.595-4.805 8.685-.99 8.685-.99s4.044 3.964-.526 8.743C25.514 30.245 16 32 16 32z"/>
        <path stroke="#fff" fill="${color}" d="M15.938 32S6 17.938 6 11.938C6 .125 15.938 0 15.938 0S26 .125 26 11.875C26 18.062 15.938 32 15.938 32zM16 6a4 4 0 100 8 4 4 0 000-8z"/>
      </svg>`;
  
    const icon = L.divIcon({
      className: "marker",
      html: svgTemplate,
      iconSize: [40, 40],
      iconAnchor: [12, 24],
      popupAnchor: [7, -16],
    });
  
    return icon;
  }

  function addLogToDiv(text, mapID) {
    const id = "map" + mapID;
    const logDiv = document.getElementById(id);
    logDiv.innerHTML += text + '<br>';
    console.log(text);
  }