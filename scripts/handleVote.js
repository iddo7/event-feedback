/* Variables */

let buttonVoteGreen = document.querySelector("#icon-vote-green")
let buttonVoteYellow = document.querySelector("#icon-vote-yellow")
let buttonVoteRed = document.querySelector("#icon-vote-red")
let welcomeMessage = document.querySelector("#welcome-message")
let thanksMessage = document.querySelector("#thanks-message")
let voteTypeDisplay = document.querySelector(".display-vote-type")
let backBtn = document.querySelector(".back-btn")
let allButtons = [buttonVoteGreen, buttonVoteYellow, buttonVoteRed]

voteAs = getQueryParam('type')
eventId = getQueryParam('id')

let colorGreen = '#008a64';
let colorYellow = '#ffc45d';
let colorRed = '#df2350';
let colorDarker = '#363636';
let delayBetweenVotesMs = 2000

let onClickGreen = () => { handleClick('green') }
let onClickYellow = () => { handleClick('yellow') }
let onClickRed = () => { handleClick('red') }




/* Start */

initialize()

buttonVoteGreen.addEventListener('click', onClickGreen)
buttonVoteYellow.addEventListener('click', onClickYellow)
buttonVoteRed.addEventListener('click', onClickRed)




/* Functions */

function handleClick(voteType) {
    switch (voteType) {

        case 'green':
            animationPreparation()

            // Animation
            let greenVoteAnimation = anime.timeline({
                easing: 'cubicBezier(0, .7, .2, 1)',
                duration: 500,
                complete: function () {
                    redirectTo(`increment-vote.php?type=${voteAs}&id=${eventId}&feedback=${voteType}`)
                }
            })
            // Changing colors
            .add({ targets: 'body', backgroundColor: colorGreen }, 0)
            .add({ targets: [buttonVoteYellow, buttonVoteRed], color: colorGreen }, 0)
            // Hiding elements
            .add({ targets: [voteTypeDisplay, welcomeMessage, backBtn], opacity: 0 }, 0)
            // Showing thanks message
            .add({ targets: thanksMessage, opacity: 1, easing: 'easeInOutQuad' }, '+= 25')
            // Going back to start state
            .add({ targets: 'body', backgroundColor: colorDarker }, delayBetweenVotesMs)
            .add({ targets: buttonVoteYellow, color: colorYellow }, delayBetweenVotesMs)
            .add({ targets: buttonVoteRed, color: colorRed }, delayBetweenVotesMs)
            .add({ targets: [voteTypeDisplay, welcomeMessage, backBtn], opacity: 1 }, delayBetweenVotesMs)
            .add({ targets: thanksMessage, opacity: 0, easing: 'easeInOutQuad' }, delayBetweenVotesMs - 500)
            break;


        case 'yellow':
                animationPreparation()
                changeColor(thanksMessage, colorDarker)

                // Animation
                let yellowVoteAnimation = anime.timeline({
                    easing: 'cubicBezier(0, .7, .2, 1)',
                    duration: 500,
                    complete: function () {
                        redirectTo(`increment-vote.php?type=${voteAs}&id=${eventId}&feedback=${voteType}`)
                    }
                })
                // Changing colors
                .add({ targets: 'body', backgroundColor: colorYellow }, 0)
                .add({ targets: [buttonVoteGreen, buttonVoteRed], color: colorYellow }, 0)
                // Hiding elements
                .add({ targets: [voteTypeDisplay, welcomeMessage, backBtn], opacity: 0 }, 0)
                // Showing thanks message
                .add({ targets: thanksMessage, opacity: 1, easing: 'easeInOutQuad' }, '+= 25')
                // Going back to start state
                .add({ targets: 'body', backgroundColor: colorDarker }, delayBetweenVotesMs)
                .add({ targets: buttonVoteGreen, color: colorGreen }, delayBetweenVotesMs)
                .add({ targets: buttonVoteRed, color: colorRed }, delayBetweenVotesMs)
                .add({ targets: [voteTypeDisplay, welcomeMessage, backBtn], opacity: 1 }, delayBetweenVotesMs)
                .add({ targets: thanksMessage, opacity: 0, easing: 'easeInOutQuad' }, delayBetweenVotesMs - 500)
                break;


        case 'red':
            animationPreparation()

            // Animation
            let redVoteAnimation = anime.timeline({
                easing: 'cubicBezier(0, .7, .2, 1)',
                duration: 500,
                complete: function () {
                    redirectTo(`increment-vote.php?type=${voteAs}&id=${eventId}&feedback=${voteType}`)
                }
            })
            // Changing colors
            .add({ targets: 'body', backgroundColor: colorRed }, 0)
            .add({ targets: [buttonVoteGreen, buttonVoteYellow], color: colorRed }, 0)
            // Hiding elements
            .add({ targets: [voteTypeDisplay, welcomeMessage, backBtn], opacity: 0 }, 0)
            // Showing thanks message
            .add({ targets: thanksMessage, opacity: 1, easing: 'easeInOutQuad' }, '+= 25')
            // Going back to start state
            .add({ targets: 'body', backgroundColor: colorDarker }, delayBetweenVotesMs)
            .add({ targets: buttonVoteGreen, color: colorGreen }, delayBetweenVotesMs)
            .add({ targets: buttonVoteYellow, color: colorYellow }, delayBetweenVotesMs)
            .add({ targets: [voteTypeDisplay, welcomeMessage, backBtn], opacity: 1 }, delayBetweenVotesMs)
            .add({ targets: thanksMessage, opacity: 0, easing: 'easeInOutQuad' }, delayBetweenVotesMs - 500)
            break;


    }
}



function initialize() {
    hide(thanksMessage)
    changeColor(welcomeMessage, 'rgb(215, 215, 215)')
    changeColor(thanksMessage, 'white')

    changeColor(buttonVoteGreen, colorGreen)
    changeColor(buttonVoteYellow, colorYellow)
    changeColor(buttonVoteRed, colorRed)

    // "Clickable" cursor
   changeCursors([buttonVoteGreen, buttonVoteYellow, buttonVoteRed], 'pointer')
}

function animationPreparation() {
    // Removing Event Listeners
    buttonVoteGreen.removeEventListener('click', onClickGreen)
    buttonVoteYellow.removeEventListener('click', onClickYellow)
    buttonVoteRed.removeEventListener('click', onClickRed)

    show(thanksMessage)

    // "Non-Clickable" cursor
    changeCursors([buttonVoteGreen, buttonVoteYellow, buttonVoteRed], 'default')
}

function changeColor(element, newColor) {
    element.style.color = newColor
}

function changeCursors(elements, newCursorType) {
    elements.forEach(element => {
        element.style.cursor = newCursorType
    })
}

function hide(element) {
    element.style.display = 'none'
}

function show(element) {
    element.style.display = 'inline'
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