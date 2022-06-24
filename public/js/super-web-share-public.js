'use strict';
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
          if( x[i].classList.contains( 'shortcode-button' ) ) continue;
          x[i].style.display = 'none';
      }
      let f = document.querySelectorAll( '.sws-fallback-off' );
      if( f.length > 0  ){
          f.forEach( m => m.style.display="none" );
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
          console.log('Error occurred while sharing: ' + error);
          return;
      }
  }
}

const getPageMeta = () =>{
    var mData={};
    if (document.querySelector('meta[property="og:description"]') != null) {
        mData.meta_desc = document.querySelector('meta[property="og:description"]').content;
    } else if (document.querySelector('meta[property="description"]') != null) {
        mData.meta_desc = document.querySelector('meta[property="description"]').content;
    } else {
        mData.meta_desc = document.title;
    }

    if (document.querySelector('meta[property="og:title"]') != null) {
        mData.meta_title = document.querySelector('meta[property="og:title"]').content;
    } else if (document.querySelector('meta[property="description"]') != null) {
        mData.meta_title = document.querySelector('meta[property="description"]').content;
    } else {
        mData.meta_title = document.title;
    }

    if (document.querySelector('meta[property="og:url"]') != null) {
        mData.meta_url = document.querySelector('meta[property="og:url"]').content;
    } else {
        mData.meta_url = window.location.href;
    }

    return mData;
}

document.addEventListener('click', function(SuperWebShare) {
  var target = SuperWebShare.target;

  if (target.classList.contains('superwebshare_prompt') || target.parentNode.classList.contains('superwebshare_prompt')  || target.parentNode.parentNode.classList.contains('superwebshare_prompt')) {
      let {meta_desc, meta_title, meta_url}=getPageMeta();
      
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
          let {meta_url}=getPageMeta();
          navigator.clipboard.writeText(meta_url)
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
              let {meta_title, meta_url}=getPageMeta();
              let moreD = this.getAttribute('data-params') || "";
              let type =  this.getAttribute('data-type') || "";
            
              let urlParams = {
                  'facebook':`https://www.facebook.com/sharer/sharer.php?u=${encodeURI(meta_url)}${encodeURI(moreD)}`,
                  'twitter':`http://twitter.com/share?text=${encodeURI(meta_title)}&url=${encodeURI(meta_url)}${encodeURI(moreD)}`,
                  'linkedin':`https://www.linkedin.com/sharing/share-offsite?url=${encodeURI(meta_url)}${encodeURI(moreD)}`,
                  'whatsapp':`https://api.whatsapp.com/send?text=${encodeURI(meta_url)}${encodeURI(moreD)}`,
              }
              if( 'whatsapp' == type ){
                window.open(urlParams[type]);
              }else{
                  window.open(urlParams[type], null, 'height=500,width=500');
              }
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