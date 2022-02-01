function dynamisimOnLoad () {
  function scrollHandler(e) {
    const isMobile = Math.min(window.screen.width, window.screen.height) < 768;

    if(!isMobile) {
      return;
    }

    if(window.scrollY >= 75) {
      document.getElementById('page').classList.add('scrolled')
    } else {
      document.getElementById('page').classList.remove('scrolled')
    }
  }  
  window.addEventListener('scroll', scrollHandler);

  setTimeout(scrollHandler, 2000);

  function navigate(aTag) {
    document.location = aTag.getAttribute('href');
  }

  function clickTopLevelDropdownToggle(e) {
    var el = e.target;

    if(el.classList.contains('show')) {
      navigate(el);
    }
  }
  document.querySelectorAll('#main-nav > ul > li.dropdown > a').forEach(function(link) {
    link.addEventListener('click', clickTopLevelDropdownToggle);
  });

  document.querySelectorAll('#main-nav .dropdown-item > a').forEach(function(link) {
    link.addEventListener('click', navigate.bind(null, link));
  })
}

window.addEventListener("load", dynamisimOnLoad, true);