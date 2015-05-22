document.addEventListener("DOMContentLoaded", function() {
  var suckDataButton = document.getElementById('suck-product-data');
  suckDataButton.addEventListener("click", function(e) {
    e.preventDefault();

    if( gpsucker.baseURL === '' ) {
      alert('A base URL should be defined in the settings first (Settings > Globie Product Sucker > Store base URL)');
      return;
    }

    productURL = document.getElementById('gpsucker-url-field').value;
    productId = getUrlVars(productURL).product_id; 
    if( productId == '' ) {
      alert('Product ID needed');
      return;
    }

    // Turn on spinner
    document.getElementById('globie-spinner').style.display = "inline-block";

    // Get video data
    var xmlhttp;
    if (window.XMLHttpRequest) {
      xmlhttp = new XMLHttpRequest();
    } else {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open('GET', gpsucker.baseURL + productId, true);
    xmlhttp.onreadystatechange = function() {
      if( xmlhttp.readyState == 4 ) {
        if( xmlhttp.status == 200 ) {
          var response = JSON.parse(xmlhttp.responseText);
          if(response.success) {

            var product = response.product;

            // Set title
            document.getElementById('title').focus();
            document.getElementById('title').value = product.name;

            // Set content
            if( document.getElementById('content') ) {
              
              // Clean description text
              var description = jQuery.parseHTML(product.description);
              var cleanDescription = '';
              jQuery(description).each( function(i) {
                if( jQuery.trim(this.textContent) !== '') {
                  cleanDescription += jQuery.trim(this.textContent);
                }
              });

              document.getElementById('content').value = cleanDescription;
              
            } 

            // Set featured image
            var inside = document.getElementById('postimagediv').getElementsByClassName('inside')[0];
            inside.innerHTML = '';

            //    Set Thumbnail
            var featImg = document.createElement('img');
            featImg.setAttribute('id', 'gpsucker-img');
            featImg.setAttribute('src', product.image);
            featImg.setAttribute('width', 266);
            inside.appendChild(featImg);

            //    Set url in hidden field
            document.getElementById('gpsucker-img-field').value = product.image;


            //  Set brand
            if(document.getElementById('_igv_product_brand') && product.manufacturer !== '') {
              document.getElementById('_igv_product_brand').value = product.manufacturer;
            }

          }
        }
      } else {
        if( xmlhttp.responseText ) {
          var responseText = JSON.parse(xmlhttp.responseText);
          if ( responseText.error) {
            alert("Product Error: " + responseText.error);
          }
        }
      }

    // Turn off spinner
    document.getElementById('globie-spinner').style.display = "none";
    }
    xmlhttp.send();
  });
});

function getUrlVars(url) {
  var vars = [], hash;
  var hashes = url.slice(url.indexOf('?') + 1).split('&');
  for(var i = 0; i < hashes.length; i++) {
    hash = hashes[i].split('=');
    vars.push(hash[0]);
    vars[hash[0]] = hash[1];
  }
  return vars;
}
