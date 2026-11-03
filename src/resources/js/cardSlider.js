document.addEventListener('DOMContentLoaded', () => {
  const slider = document.getElementById('slider');
  const nextBtn = document.getElementById('nextBtn');
  const prevBtn = document.getElementById('prevBtn');
  const slides = Array.from(slider.querySelectorAll('img'));
  const slideCount = slides.length;
  let slideIndex = 0;
  const photo1btn = document.getElementById('photo1')
  const photo2btn = document.getElementById('photo2')
  const photo3btn = document.getElementById('photo3')

  function updateSlider() 
  {
    slides.forEach((slide, index) => {
      if (index === slideIndex)
      {
        slide.style.display = 'block';
      }
      else
      {
        slide.style.display = 'none';
      };
    });
  };

  function showNextSlide()
  {
    slideIndex = (slideIndex + 1) % slideCount;
    updateSlider();
  }

  nextBtn.addEventListener('click', showNextSlide);

  function showPrevSlide()
  {
    slideIndex = (slideIndex - 1 + slideCount) % slideCount;
    updateSlider();
  }

  prevBtn.addEventListener('click', showPrevSlide);

  photo1btn.addEventListener('click', function(){
    slideIndex = 0;
    updateSlider();
  })

  photo2btn.addEventListener('click', function(){
    slideIndex = 1;
    updateSlider();
  })

  photo3btn.addEventListener('click', function(){
    slideIndex = 2;
    updateSlider();
  })

  updateSlider();

});