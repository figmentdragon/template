// -------------------- //
// Function definitions //
// -------------------- //

function deactivateSelect(select) {
  if (!select.classList.contains('active')) return;

  const optList = select.querySelector('.optList');

  optList.classList.add('hidden');
  select.classList.remove('active');
}

function activeSelect(select, selectList) {
  if (select.classList.contains('active')) return;

  selectList.forEach(deactivateSelect);
  select.classList.add('active');
};

function toggleOptList(select, show) {
  const optList = select.querySelector('.optList');

  optList.classList.toggle('hidden');
}

function highlightOption(select, option) {
  const optionList = select.querySelectorAll('.option');

  optionList.forEach((other) => {
    other.classList.remove('highlight');
  });

  option.classList.add('highlight');
};

function updateValue(select, index) {
  const nativeWidget = select.previousElementSibling;
  const value = select.querySelector('.value');
  const optionList = select.querySelectorAll('.option');

  optionList.forEach((other) => {
    other.setAttribute('aria-selected', 'false');
  });

  optionList[index].setAttribute('aria-selected', 'true');

  nativeWidget.selectedIndex = index;
  value.innerHTML = optionList[index].innerHTML;
  highlightOption(select, optionList[index]);
};

function getIndex(select) {
  const nativeWidget = select.previousElementSibling;

  return nativeWidget.selectedIndex;
};

// ------------- //
// Event binding //
// ------------- //

window.addEventListener("load", () => {
  const form = document.querySelector('form');

  form.classList.remove("no-widget");
  form.classList.add("widget");
});

window.addEventListener('load', () => {
  const selectList = document.querySelectorAll('.select');

  selectList.forEach((select) => {
    const optionList = select.querySelectorAll('.option');
    const selectedIndex = getIndex(select);

    select.tabIndex = 0;
    select.previousElementSibling.tabIndex = -1;

    updateValue(select, selectedIndex);

    optionList.forEach((option, index) => {
      option.addEventListener('mouseover', () => {
        highlightOption(select, option);
      });

      option.addEventListener('click', (event) => {
        updateValue(select, index);
      });
    });

    select.addEventListener('click', (event) => {
      toggleOptList(select);
    });

    select.addEventListener('focus', (event) => {
      activeSelect(select, selectList);
    });

    select.addEventListener('blur', (event) => {
      deactivateSelect(select);
    });

    select.addEventListener('keyup', (event) => {
      let index = getIndex(select);

      if (event.keyCode === 27) {
        deactivateSelect(select);
      }
      if (event.keyCode === 40 && index < optionList.length - 1) {
        index++;
      }
      if (event.keyCode === 38 && index > 0) {
        index--;
      }

      updateValue(select, index);
    });
  });
});
