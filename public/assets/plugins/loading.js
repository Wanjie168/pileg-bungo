function showLoading($judul){
  var title    = $judul;
  var icon     = "loading";
  var duration = 9999*9999; // Infinite duration
  $.Toast.showToast({title: title,duration: duration, icon:icon,image: ''});
};

function hideLoading() {
  $.Toast.hideToast();
};