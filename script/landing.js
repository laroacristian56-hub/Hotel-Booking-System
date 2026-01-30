let next = document.querySelector('.next')
let prev = document.querySelector('.prev')

next.addEventListener('click', function(){
    let items = document.querySelectorAll('.items')
    document.querySelector('.slide').appendChild(items[0])
})

prev.addEventListener('click', function(){
    let items = document.querySelectorAll('.items')
    document.querySelector('.slide').prepend(items[items.length - 1]) 
})

//For self move images//

let Next = document.querySelector('.next');
let Prev = document.querySelector('.prev');
let slider = document.querySelector('.ImageSlider');


function moveNext() {
    let items = document.querySelectorAll('.items');
    document.querySelector('.slide').appendChild(items[0]);
}


function movePrev() {
    let items = document.querySelectorAll('.items');
    document.querySelector('.slide').prepend(items[items.length - 1]);
}


Next.addEventListener('click', moveNext);
Prev.addEventListener('click', movePrev);


let autoPlay = setInterval(moveNext, 3000); 

slider.addEventListener('mouseenter', () => {
    clearInterval(autoPlay);
});


slider.addEventListener('mouseleave', () => {
    autoPlay = setInterval(moveNext, 3000);
});let next = document.querySelector('.next')
let prev = document.querySelector('.prev')

next.addEventListener('click', function(){
    let items = document.querySelectorAll('.items')
    document.querySelector('.slide').appendChild(items[0])
})

prev.addEventListener('click', function(){
    let items = document.querySelectorAll('.items')
    document.querySelector('.slide').prepend(items[items.length - 1]) 
})

//For self move images//

let Next = document.querySelector('.next');
let Prev = document.querySelector('.prev');
let slider = document.querySelector('.ImageSlider');


function moveNext() {
    let items = document.querySelectorAll('.items');
    document.querySelector('.slide').appendChild(items[0]);
}


function movePrev() {
    let items = document.querySelectorAll('.items');
    document.querySelector('.slide').prepend(items[items.length - 1]);
}


Next.addEventListener('click', moveNext);
Prev.addEventListener('click', movePrev);


let autoPlay = setInterval(moveNext, 3000); 

slider.addEventListener('mouseenter', () => {
    clearInterval(autoPlay);
});


slider.addEventListener('mouseleave', () => {
    autoPlay = setInterval(moveNext, 3000);
});