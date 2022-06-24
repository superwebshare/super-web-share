var DOMReady = function(callback) {
  if (document.readyState === "interactive" || document.readyState === "complete") {
      callback();
  } else if (document.addEventListener) {
      document.addEventListener('DOMContentLoaded', callback());
  } else if (document.attachEvent) {
      document.attachEvent('onreadystatechange', function() {
          if (document.readyState === 'complete') {
              callback();
          }
      });
  }
};

DOMReady(function() {
  setTimeout(hasPermission, 200);
   if (window.location.protocol != "https:") {
       if( document.querySelector(".sws-copy") ) document.querySelector(".sws-copy").style.display = 'none'
   }
});

function hasPermission() {
  if ((typeof navigator.share === 'undefined' || !navigator.share) && window.superWebShareFallback.superwebshare_fallback_enable != 'enable') {
      var x = document.getElementsByClassName("superwebshare_prompt") || document.getElementsByClassName(".superwebshare_prompt .span");
      var i;
      for (i = 0; i < x.length; i++) {
          x[i].style.display = 'none';
      }
      console.log('SuperWebShare: Your browser does not seems to support SuperWebShare, as the browser is incompatible');
  }
}
async function SuperWebSharefn(Title, URL, Description) {
  if (typeof navigator.share === 'undefined' || !navigator.share) {
      modal();
  } else if (window.location.protocol != 'https:') {
      console.log('SuperWebShare: Seems like the website is not served fully via https://. As for supporting SuperWebShare the website should be served fully via https://');
  } else {
      const TitleConst = Title;
      const URLConst = URL;
      const DescriptionConst = Description;

      try {
          await navigator.share({ title: TitleConst, text: DescriptionConst, url: URLConst });
      } catch (error) {
          console.log('Error occured while sharing: ' + error);
          return;
      }
  }
}

document.addEventListener('click', function(SuperWebShare) {
  var target = SuperWebShare.target;

  if (target.classList.contains('superwebshare_prompt') || target.parentNode.classList.contains('superwebshare_prompt')) {
      var meta_desc, meta_title, meta_url
      if (document.querySelector('meta[property="og:description"]') != null) {
          meta_desc = document.querySelector('meta[property="og:description"]').content;
      } else if (document.querySelector('meta[property="description"]') != null) {
          meta_desc = document.querySelector('meta[property="description"]').content;
      } else {
          meta_desc = document.title;
      }

      if (document.querySelector('meta[property="og:title"]') != null) {
          meta_title = document.querySelector('meta[property="og:title"]').content;
      } else if (document.querySelector('meta[property="description"]') != null) {
          meta_title = document.querySelector('meta[property="description"]').content;
      } else {
          meta_title = document.title;
      }

      if (document.querySelector('meta[property="og:url"]') != null) {
          meta_url = document.querySelector('meta[property="og:url"]').content;
      } else {
          meta_url = window.location.href;
      }

      SuperWebSharefn(meta_title, meta_url, meta_desc);
  } else if (target.classList.contains('sws-modal-bg')) {
      modal('hide');
  }
});

DOMReady(function() {
  let copyButton = document.querySelector('.sws-copy a');
  if (copyButton) {

      copyButton.addEventListener('click', function(e) {
          e.preventDefault()
          navigator.clipboard.writeText(this.dataset.url)
            let self = this;
            let child = self.querySelector('span')
            child.innerText = "Link Copied ✔";
            setTimeout(function() {
              child.innerText = "Copy Link"
          }, 4000)
          return false;
      });
  }

  let btnModalClose = document.querySelector('.sws-modal-close');
  if (btnModalClose) {
      btnModalClose.addEventListener('click', function(e) {
          e.preventDefault()
          modal('hide');
          return false;
      })
  }

  document.querySelectorAll('.sws-open-in-tab').forEach(
      function(item) {
          item.addEventListener('click', function(ev) {
              ev.preventDefault();
              console.log(this.getAttribute('href'));
              window.open(this.getAttribute('href'), null, 'height=500,width=500');
              return false;

          })
      });


})
const modal = (action = 'show') => {
  let modal = document.querySelector('.sws-modal-bg');
  if (!modal) return;
  if (action == 'hide') {
      modal.style.display = 'none';
  } else {
      modal.style.display = 'flex';
  }
};