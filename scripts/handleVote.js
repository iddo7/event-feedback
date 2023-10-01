
let buttonVoteGreen = document.querySelector("#icon-vote-green")
let buttonVoteYellow = document.querySelector("#icon-vote-yellow")
let buttonVoteRed = document.querySelector("#icon-vote-red")
let allButtons = [buttonVoteGreen, buttonVoteYellow, buttonVoteRed]

let colorGreen = '#008a64';
let colorYellow = '#ffc45d';
let colorRed = '#df2350';








/* Start */

initializeAllButtons()

buttonVoteGreen.addEventListener('click', () => { handleClick('green') })
buttonVoteYellow.addEventListener('click', () => { handleClick('yellow') })
buttonVoteRed.addEventListener('click', () => { handleClick('red') })


function handleClick(voteType) {
    switch (voteType) {

        case 'green':
            anime({
                targets: buttonVoteGreen,
                fontSize: '1000rem',
            })
            break;


        case 'yellow':
            break;


        case 'red':
            break;


    }
}



function initializeAllButtons() {
    changeColor(buttonVoteGreen, colorGreen)
    changeColor(buttonVoteYellow, colorYellow)
    changeColor(buttonVoteRed, colorRed)
}

function changeColor(element, newColor) {
    element.style.color = newColor
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