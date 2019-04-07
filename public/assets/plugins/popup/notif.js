$(document).ready(function(){
	popupConfirm = new jBox('Confirm', {
		confirmButton: 'Yakin',
		cancelButton: 'Batal'
	});
})

function reDeclareConfirm() {
	popupConfirm.destroy();
	popupConfirm = new jBox('Confirm', {
		confirmButton: 'Yakin',
		cancelButton: 'Batal'
	});
}

function miniNotif($type,$msg) {
	if($type=="success")
		bgColor='green'; else
	if($type=="error")
		bgColor='red'; else
	if($type=="info")
		bgColor='blue'; else
		bgColor='yellow';
	new jBox('Notice', {
		animation: 'flip',
		color: bgColor,
		autoClose: Math.random() * 8000 + 2000,
		content: $msg,
		delayOnHover: true,
		showCountdown: true,
		closeButton: true
	});
}

function showPopup($judul,$msg) {
	modal = new jBox('Modal', {
	  title: $judul,
	  content: '<div style="line-height: 30px;">'+$msg+'</div>',
	  theme: 'ModalBorder',
	});
	modal.open();
}