jQuery(document).ready(function ($) {
  $(".superwebshare-colorpicker").wpColorPicker(); // Color picker
});

function SuperWebShareRighTLeft() {
  var x = document.getElementById("superwebshare_settings[floating_position]").value;
  document.getElementById("rightleft").innerHTML = " " + x;
}

jQuery(document).ready(function ($) {
  if (typeof navigator.share === "undefined" || !navigator.share) {
    var share = "yes";
  }

  const buttonNames = ["floating", "inline"];
  for (i in buttonNames) {
    let floatingPostTypes = jQuery(
      `[name="superwebshare_${buttonNames[i]}_settings[${buttonNames[i]}_display_pages][]"]`
    );
    let manFloatingActive = jQuery(
      `[name="superwebshare_${buttonNames[i]}_settings[superwebshare_${buttonNames[i]}_enable]"]`
    );
    floatingPostTypes.change(function () {
      let anyOneActive = false;

      floatingPostTypes.each(function (input) {
        if ($(this).is(":checked")) {
          anyOneActive = true;
        }
      });
      if (anyOneActive != true) {
        manFloatingActive.prop("checked", false);
      } else {
        manFloatingActive.prop("checked", true);
      }
    });
    manFloatingActive.change(function () {
      let anyOneActive = false;

      floatingPostTypes.each(function (input) {
        if ($(this).is(":checked")) {
          anyOneActive = true;
        }
      });
      if (anyOneActive != true) {
        floatingPostTypes.prop("checked", true);
      }
    });
  }

  jQuery(".sws-appearance-icons input").change(function (e) {
    let svg = jQuery(this).next().find("svg").html();
    if (svg.length <= 0) return;
    jQuery(".sws-appearance-style .superwebshare_button svg").html(svg);
  });

  jQuery(".button-text-color").wpColorPicker({
    change: function (event, ui) {
      jQuery(".superwebshare_button").css("color", ui.color.toString());
    },
  });

  //drag and and sort networks

  const networksChecked = document.querySelectorAll(".sws-social-networks input:checked");
  const networks = document.querySelectorAll(".sws-social-networks input");
  const sortingContainer = document.querySelector(".sws-selected-social-networks");
  let lastMobileDragY = 0;
  let dropTarget = null;
  let dropTargetPos = 0;
  let networksObj = [];
  networksChecked.forEach(function (v) {
    networksObj.push({
      ...v.dataset,
      inputElement: v,
    });
  });

  // In the page load make a sorting as per data index Number.
  networksObj = networksObj.sort((a, b) => {
    b.index = b.index || 0;
    a.index = a.index || 0;
    if (a.index < b.index) {
      return -1;
    }
    if (a.index > b.index) {
      return 1;
    }
    return 0;
  });

  function generateNetworkSortList() {
    sortingContainer.innerHTML = "";
    let topIndex = 0;
    networksObj.forEach((network) => {
      const html = `
            <div class="sws-selected-social-network sws-selected-icon-${network.key}" draggable="false" data-key="${network.key}">
							<div class="sws-social-network-wrap">
								<div class="flex items-center">
									<div class="sws-network-handle px-3 h-full flex items-center" >
										<span class="dashicons-menu dashicons-before "></span>
										<input type="hidden" class="!hidden input-network" name="superwebshare_fallback_settings[fallback_social_networks][]" value="${network.key}">
									</div>
									<span class="sws-icon-wrap"  style="background-color:${network.color}">
                  ${network.icon}
									</span>
									<span class="sws-network-name">
                  ${network.name}
									</span>
								</div>
								<div class="sws-social-network-actions">
									<a href="#" class="sws-action-delete" data-key="${network.key}">
										<span class="dashicons-trash dashicons-before "></span> Delete
									</a>
								</div>
							</div>
						</div>`;

      const parser = new DOMParser();
      const vDOM = parser.parseFromString(html, "text/html");
      const element = vDOM.body.firstChild;

      element.style.position = "absolute";
      element.style.top = topIndex + "px";
      element.style.left = 0;
      element.style.width = "100%";

      sortingContainer.appendChild(element);

      network.element = element;
      element.style.width = element.clientWidth + "px";
      topIndex += element.clientHeight;

      function swsOnMouseDown(emd) {
        const mouseDownClientY = emd.type === "touchstart" ? emd.touches[0].clientY : emd.clientY;

        const mouseDownTop = mouseDownClientY;
        const elOffset = getOffsets(element, emd);
        element.classList.add("sws-network-on-drag");
        element.style.top = mouseDownClientY - elOffset.initY + "px";
        element.style.left = emd.clientX - elOffset.initX + "px";
        element.style.position = "fixed";
        element.style.zIndex = 99999;

        document.body.classList.add("sws-network-on-dragging");

        if (event.cancelable) {
          emd.preventDefault(); // Only cancel if the event is cancelable
        }

        updateOffset();

        function onMouseMove(dmm) {
          const { clientY, clientX } = dmm.type === "touchmove" ? dmm.touches[0] : dmm;
          lastMobileDragY = clientY;
          element.style.top = clientY - elOffset.initY + "px";
          element.style.left = clientX - elOffset.initX + "px";
          networksObj.forEach((_network) => {
            if (_network.element == element) {
              return;
            }

            if (elOffset.top >= _network.offset.top) {
              if (clientY >= _network.offset.top + _network.offset.height) {
                _network.element.style.transform = "translateY(0)";
              } else {
                dropTarget = _network;
                dropTargetPos = -1;
                _network.element.style.transform = "translateY(100%)";
              }
            } else {
              if (clientY <= _network.offset.top) {
                _network.element.style.transform = "translateY(0)";
              } else {
                dropTarget = _network;
                dropTargetPos = 1;
                _network.element.style.transform = "translateY(-100%)";
              }
            }
          });
        } //onMouseMove -  END

        function onMouseUp(dmd) {
          document.body.classList.remove("sws-network-on-dragging");

          const dmdClientY = dmd.type === "touchend" ? lastMobileDragY : dmd.clientY;
          const containerRect = sortingContainer.getBoundingClientRect();

          const whichMoving = networksObj.find((ell) => {
            return ell.key == element.dataset.key;
          });

          let localTop = dmdClientY - containerRect.top;
          localTop = localTop <= 0 ? 0 : localTop;
          const ln = localTop / element.clientHeight;
          const pos = mouseDownTop > dmdClientY ? Math.floor(ln) : Math.ceil(ln);

          let group1 = networksObj.slice(0, pos);
          let group2 = networksObj.slice(pos, networksObj.length);

          group1 = group1.filter((ell) => {
            return ell.key != element.dataset.key;
          });
          group2 = group2.filter((ell) => {
            return ell.key != element.dataset.key;
          });
          networksObj = [...group1, ...[whichMoving], ...group2];
          document.removeEventListener("mousemove", onMouseMove);
          document.removeEventListener("touchmove", onMouseMove);
          document.removeEventListener("mouseup", onMouseUp);
          document.removeEventListener("touchend", onMouseUp);
          window.removeEventListener("scroll", updateOffset);
          generateNetworkSortList();
        }

        document.addEventListener("mousemove", onMouseMove);
        document.addEventListener("touchmove", onMouseMove);
        document.addEventListener("mouseup", onMouseUp);
        document.addEventListener("touchend", onMouseUp);
        window.addEventListener("scroll", updateOffset);
      }

      element.querySelector(".sws-network-handle").addEventListener("mousedown", swsOnMouseDown);
      element.querySelector(".sws-network-handle").addEventListener("touchstart", swsOnMouseDown);
    });

    sortingContainer.style.height = topIndex + "px";
    const deleteBtn = sortingContainer.querySelectorAll(".sws-action-delete");
    deleteBtn &&
      deleteBtn.forEach((dBtn) => {
        dBtn.addEventListener("click", function (e) {
          const dataset = this.dataset;
          const elem = document.querySelector(`.sws-social-networks input[data-key="${dataset.key}"]`);
          elem && elem.click();
          e.preventDefault();
        });
      });
  }

  networks.forEach((el) =>
    el.addEventListener("change", function (e) {
      const dataset = this.dataset;
      if (this.checked) {
        networksObj.push({
          ...dataset,
          element: this,
        });
      } else {
        if (networksObj.length <= 1) {
          this.checked = true;
          return;
        }
        networksObj = networksObj.filter((fel) => fel.key !== dataset.key);
      }

      generateNetworkSortList();
    })
  );
  window.onresize = function () {
    window.requestAnimationFrame(generateNetworkSortList);
  };
  generateNetworkSortList();

  function updateOffset() {
    networksObj.forEach((network) => {
      network.offset = getOffsets(network.element);
    });
  }
  function getOffsets(element, emd = null) {
    const clientRect = element.getBoundingClientRect();
    let initY, initX;
    if (emd) {
      if (emd.type === "touchstart") {
        initY = emd.touches[0].pageY - (clientRect.top + window.scrollY);
        initX = emd.touches[0].pageX - (clientRect.left + window.scrollX);
      } else {
        initY = emd.pageY - (clientRect.top + window.scrollY);
        initX = emd.pageX - (clientRect.left + window.scrollX);
      }
    }
    return {
      top: clientRect.top,
      left: clientRect.left,
      height: element.clientHeight,
      initY,
      initX,
    };
  }

  const $socialNetworksChoose = $(".sws-social-networks-wrap");
  const $networkChooseToggle = $(".social-networks-choose-toggle");
  const netWorkText = $networkChooseToggle.html();
  $networkChooseToggle.click(function () {
    $socialNetworksChoose.slideToggle(function () {
      $networkChooseToggle.html(
        $socialNetworksChoose.is(":hidden") ? netWorkText : $networkChooseToggle.attr("data-close-text")
      );
    });
  });
});
