
let buttonVoteGreen = document.querySelector("#icon-vote-green")
let buttonVoteYellow = document.querySelector("#icon-vote-yellow")
let buttonVoteRed = document.querySelector("#icon-vote-red")
let messageDisplay = document.querySelector("#message")
let allButtons = [buttonVoteGreen, buttonVoteYellow, buttonVoteRed]

let colorGreen = '#008a64';
let colorYellow = '#ffc45d';
let colorRed = '#df2350';
let colorDarker = '#363636';

let onClickGreen = () => { handleClick('green') }
let onClickYellow = () => { handleClick('yellow') }
let onClickRed = () => { handleClick('red') }




/* Start */

initializeAllButtons()

buttonVoteGreen.addEventListener('click', onClickGreen)
buttonVoteYellow.addEventListener('click', onClickYellow)
buttonVoteRed.addEventListener('click', onClickRed)

function handleClick(voteType) {
    switch (voteType) {

        case 'green':

            // Removing Event Listeners
            buttonVoteGreen.removeEventListener('click', onClickGreen)
            buttonVoteYellow.removeEventListener('click', onClickYellow)
            buttonVoteRed.removeEventListener('click', onClickRed)

            // "Non-Clickable" cursor
           changeCursors([buttonVoteGreen, buttonVoteYellow, buttonVoteRed], 'default')

            // Animation
            let greenVoteAnimation = anime.timeline({
                easing: 'cubicBezier(0, .7, .2, 1)',
                duration: 500,
            })
            .add({ targets: 'body', backgroundColor: colorGreen }, 0)
            .add({ targets: [buttonVoteYellow, buttonVoteRed], color: colorGreen }, 0)
            .add({ 
                targets: messageDisplay, 
                opacity: 1,
                easing: 'easeInOutQuad'
            }, '+= 50')
            .add({ targets: 'body', backgroundColor: colorGreen })
            
            break;


        case 'yellow':
            console.log('bb')
            break;


        case 'red':
            console.log('cc')
            break;


    }
}



function initializeAllButtons() {
    changeColor(buttonVoteGreen, colorGreen)
    changeColor(buttonVoteYellow, colorYellow)
    changeColor(buttonVoteRed, colorRed)

    // "Clickable" cursor
   changeCursors([buttonVoteGreen, buttonVoteYellow, buttonVoteRed], 'pointer')
}

function changeColor(element, newColor) {
    element.style.color = newColor
}

function changeCursors(elements, newCursorType) {
    elements.forEach(element => {
        element.style.cursor = newCursorType
    })
}

function getQueryParam(key) {
    // The key is the name of variable wanted from GET
    const queryString = window.location.search;
    const urlParam = new URLSearchParams(queryString);
    return urlParam.get(key);
}

function redirectTo(location) {
    window.location.href = location
}