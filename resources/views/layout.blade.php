<!-- resources/views/layout.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
        <!-- Linking to CSS -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
        @include('nav')
        @yield('content')
</body>
 <!-- JavaScript for Dropdown -->
 <script>
    // JavaScript for Dropdown
    const menuButton = document.getElementById("menuButton");
    const mobileMenu = document.getElementById("mobileMenu");
    
    menuButton.addEventListener("click", function(event) {
        mobileMenu.classList.toggle("hidden");
        if (mobileMenu.style.maxHeight === '0px' || mobileMenu.style.maxHeight === '') {
        mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
      } else {
        mobileMenu.style.maxHeight = '0px';
      }
      
      event.stopPropagation(); // Prevent the event from reaching the document
    });
    
    // Close the menu when clicking anywhere else on the page
    document.addEventListener("click", function(event) {
        if (!mobileMenu.contains(event.target) && !menuButton.contains(event.target)) {
        mobileMenu.style.maxHeight = '0px';
        mobileMenu.classList.add("hidden");
      }
    
    });
    
    
    document.addEventListener('DOMContentLoaded', function() {
      const faqItems = document.querySelectorAll('.faq-item');
    
      faqItems.forEach((item) => {
        const question = item.querySelector('.faq-question');
        const answerWrapper = item.querySelector('.faq-answer-wrapper');
        const answer = item.querySelector('.faq-answer');
        const arrow = item.querySelector('.faq-arrow');
    
        question.addEventListener('click', function() {
          faqItems.forEach((otherItem) => {
            if (otherItem !== item) {
              const otherAnswerWrapper = otherItem.querySelector('.faq-answer-wrapper');
              const otherArrow = otherItem.querySelector('.faq-arrow');
              otherAnswerWrapper.style.maxHeight = '0px';
              otherArrow.style.transform = '';
            }
          });
    
          if (answerWrapper.style.maxHeight === '0px' || answerWrapper.style.maxHeight === '') {
            answerWrapper.style.maxHeight = answer.scrollHeight + 'px';
            arrow.style.transform = 'rotate(180deg)';
          } else {
            answerWrapper.style.maxHeight = '0px';
            arrow.style.transform = '';
          }
        });
      });
    
    
      const langButton = document.getElementById('langButton');
      const langList = document.getElementById('langList');
    
      langButton.addEventListener('click', function(event) {
        
        langList.classList.toggle("hidden");
        if (langList.style.maxHeight === '0px' || langList.style.maxHeight === '') {
          langList.style.maxHeight = langList.scrollHeight + 'px';
        } else {
          langList.style.maxHeight = '0px';
        }
        event.stopPropagation();
      });
    
      // Close the language list when clicking anywhere else on the page
      document.addEventListener('click', function(event) {
        if (!langList.contains(event.target) && !langButton.contains(event.target)) {
          langList.style.maxHeight = '0px';
          langList.classList.add("hidden");
    
        }
      });
    
      // Update the selected language
      const langItems = document.querySelectorAll('.lang-item');
      langItems.forEach((item) => {
        item.addEventListener('click', function() {
          const svg = item.querySelector('svg').outerHTML;
          const text = item.querySelector('span').innerText;
          langButton.innerHTML = `<div class="flex flex-col items-center justify-center">${svg}<span class="text-xs">${text.substring(0, 2).toUpperCase()}</span></div>`;
          langList.style.maxHeight = '0px';
          langList.classList.add('hidden');

        });
      });
    });
    
    
      </script>
      <!-- Slider Script-->
      <script>

const slider = document.querySelector(".items");
		const slides = document.querySelectorAll(".item");
		const button = document.querySelectorAll(".button");

		let current = 0;
		let prev = 4;
		let next = 1;

		for (let i = 0; i < button.length; i++) {
			button[i].addEventListener("click", () => i == 0 ? gotoPrev() : gotoNext());
		}

		const gotoPrev = () => current > 0 ? gotoNum(current - 1) : gotoNum(slides.length - 1);

		const gotoNext = () => current < 4 ? gotoNum(current + 1) : gotoNum(0);

		const gotoNum = number => {
			current = number;
			prev = current - 1;
			next = current + 1;

			for (let i = 0; i < slides.length; i++) {
				slides[i].classList.remove("active");
				slides[i].classList.remove("prev");
				slides[i].classList.remove("next");
			}

			if (next == 5) {
				next = 0;
			}

			if (prev == -1) {
				prev = 4;
			}

			slides[current].classList.add("active");
			slides[prev].classList.add("prev");
			slides[next].classList.add("next");
		}
      </script>
</html>
