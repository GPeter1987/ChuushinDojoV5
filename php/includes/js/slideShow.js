  var i = 0;  //  Start point.
  var images = [];
  var time = 1000;
  
  //  Image files in the "img/slideShow" lib.
  images[0] = 'img/slideShow/img1.jpg';
  images[1] = 'img/slideShow/img2.jpg';
  images[2] = 'img/slideShow/img3.jpg';

  //  Changing pictures
  function changePic() {
    document.slide.src = images[i];
    
    if(i < images.length-1) {
      i++;
    }
    else {
      i = 0;
    }
    
    setTimeout("changePic()", time);
    
    
  }




