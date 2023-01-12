var bars = document.querySelector(".bars");
var close = document.querySelector(".close");
var sidebar_wrapper = document.querySelector(".sidebar");
var main_wrapper = document.querySelector(".main");

var x = 0;

bars.addEventListener("click", () => {
	sidebar_wrapper.classList.toggle("sidebar-wrapped");
	main_wrapper.classList.toggle("main-wrapped");
});

close.addEventListener("click", () => {
	sidebar_wrapper.classList.toggle("sidebar-wrapped");
	main_wrapper.classList.toggle("main-wrapped");
});