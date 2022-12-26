//! Anmation show

// need : class introTitre, introTexte, introBouton
function introShowAnimate(...elements){
    // console.log(elements);:
    elements[0].forEach(element =>{
        console.log(element);
        element.classList.remove("idle__titre--hide") 
        element.classList.remove("idle__texte--hide")
        element.classList.remove("idle__bouton--hide")
    })
}

//! Anmation show CTA on scroll
/**
 * 
 * @param {any} section 
 * @param {number} pxToScroll 
 * @param {number} clientH 
 * @param  {array} elements 
 */
function showAnimeCTA(section,pxToScroll,clientH,...elements) {

    let  topElementTopViewport = section.getBoundingClientRect().top;
    if (pxToScroll > (pxToScroll + topElementTopViewport).toFixed() - clientH) {
        elements.forEach(element => {
            element.classList.remove("ctaShow__titre--hide") 
            element.classList.remove("ctaShow__texte--hide")
            element.classList.remove("ctaShow__bouton--hide")
            element.classList.remove("ctaShow__image--hide")
        });
    }
}

// function SectionGaucheShowAnimate(...element){
//     element.classList.remove("idle__titre--hide") 
//     element.classList.remove("idle__texte--hide")
//     element.classList.remove("idle__bouton--hide")
// }
// function SectionGaucheShowAnimate(...element){
//     element.classList.remove("idle__titre--hide") 
//     element.classList.remove("idle__texte--hide")
//     element.classList.remove("idle__bouton--hide")
// }