window.onload = () => {
    // show modal on mobile
    let navBtnEle = document.getElementsByClassName('navbar__toggler')[0];
    let navContentEle = document.getElementsByClassName('navbar__container')[0];
    let overlayEle = document.getElementsByClassName('navbar__overlay')[0];

    if (navBtnEle) {
        navBtnEle.addEventListener('click', (event) => {
            navBtnEle.classList.toggle('close');
            navContentEle.classList.toggle('show');
            overlayEle.classList.toggle('show');
        });
    
        let dropdownBtn = document.getElementsByClassName('navbar__user__button')[0];
        let dropdownMenuEle = document.getElementsByClassName('dropdown-menu')[0];
        
        dropdownBtn.addEventListener('click', (event) => {
            dropdownMenuEle.classList.toggle('show');
            event.preventDefault();
            event.stopPropagation();
        });
    
        // TODO: click outside menu
        document.addEventListener('click', (event) => {
            let targetElement = event.target; // clicked element
    
            do {
                if (targetElement == dropdownMenuEle) {
                    return;
                }
                // Go up the DOM.
                targetElement = targetElement.parentNode;
            } while (targetElement);
    
            dropdownMenuEle.classList.remove('show');
        });       
    }
}