document.addEventListener('DOMContentLoaded', () => {
  const slider = document.getElementById('slider');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const productCard = slider.querySelector('.productCard');

  const cardWidth = productCard.getBoundingClientRect().width + 15;
  
  nextBtn.addEventListener('click', () => {
    slider.scrollLeft += cardWidth;
  })
  prevBtn.addEventListener('click', () => {
    slider.scrollLeft -= cardWidth;
  })



  const slider2 = document.getElementById('slider2');
  const prevBtn2 = document.getElementById('prevBtn2');
  const nextBtn2 = document.getElementById('nextBtn2');
  const productCard2 = slider2.querySelector('.productCard');

  const cardWidth2 = productCard2.getBoundingClientRect().width + 15;
  
  nextBtn2.addEventListener('click', () => {
    slider2.scrollLeft += cardWidth2;
  })
  prevBtn2.addEventListener('click', () => {
    slider2.scrollLeft -= cardWidth2;
  })
})