
let buttonVoteGreen = document.querySelector("#icon-vote-green")
let buttonVoteYellow = document.querySelector("#icon-vote-yellow")
let buttonVoteRed = document.querySelector("#icon-vote-red")
let messageDisplay = document.querySelector(".message")
let voteTypeDisplay = document.querySelector(".display-vote-type")
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

function handleClick(voteType) {
    switch (voteType) {

        case 'green':

            // Removing Event Listeners
            buttonVoteGreen.removeEventListener('click', onClickGreen)
            buttonVoteYellow.removeEventListener('click', onClickYellow)
            buttonVoteRed.removeEventListener('click', onClickRed)

            changeColor(messageDisplay, '#FFFFFF')
            show(messageDisplay)

            // "Non-Clickable" cursor
            changeCursors([buttonVoteGreen, buttonVoteYellow, buttonVoteRed], 'default')

            // Animation
            let greenVoteAnimation = anime.timeline({
                easing: 'cubicBezier(0, .7, .2, 1)',
                duration: 500,
                complete: function () {
                    redirectTo(`increment-vote.php?type=${voteAs}&id=${eventId}&feedback=${voteType}`)
                }
            })
            .add({ targets: 'body', backgroundColor: colorGreen }, 0)
            .add({ targets: [buttonVoteYellow, buttonVoteRed], color: colorGreen }, 0)
            .add({ targets: voteTypeDisplay, opacity: 0 }, 0)
            .add({ targets: messageDisplay, opacity: 1, easing: 'easeInOutQuad' }, '+= 25')
            .add({ targets: 'body', backgroundColor: colorDarker }, delayBetweenVotesMs)
            .add({ targets: buttonVoteYellow, color: colorYellow }, delayBetweenVotesMs)
            .add({ targets: buttonVoteRed, color: colorRed }, delayBetweenVotesMs)
            .add({ targets: voteTypeDisplay, opacity: 1 }, delayBetweenVotesMs)
            .add({ targets: messageDisplay, opacity: 0, easing: 'easeInOutQuad' }, delayBetweenVotesMs - 500)
            break;


        case 'yellow':

                // Removing Event Listeners
                buttonVoteGreen.removeEventListener('click', onClickGreen)
                buttonVoteYellow.removeEventListener('click', onClickYellow)
                buttonVoteRed.removeEventListener('click', onClickRed)

                changeColor(messageDisplay, colorDarker)
                show(messageDisplay)

                // "Non-Clickable" cursor
                changeCursors([buttonVoteGreen, buttonVoteYellow, buttonVoteRed], 'default')

                // Animation
                let yellowVoteAnimation = anime.timeline({
                    easing: 'cubicBezier(0, .7, .2, 1)',
                    duration: 500,
                    complete: function () {
                        redirectTo(`increment-vote.php?type=${voteAs}&id=${eventId}&feedback=${voteType}`)
                    }
                })
                .add({ targets: 'body', backgroundColor: colorYellow }, 0)
                .add({ targets: [buttonVoteGreen, buttonVoteRed], color: colorYellow }, 0)
                .add({ targets: voteTypeDisplay, opacity: 0 }, 0)
                .add({ targets: messageDisplay, opacity: 1, easing: 'easeInOutQuad' }, '+= 25')
                .add({ targets: 'body', backgroundColor: colorDarker }, delayBetweenVotesMs)
                .add({ targets: buttonVoteGreen, color: colorGreen }, delayBetweenVotesMs)
                .add({ targets: buttonVoteRed, color: colorRed }, delayBetweenVotesMs)
                .add({ targets: voteTypeDisplay, opacity: 1 }, delayBetweenVotesMs)
                .add({ targets: messageDisplay, opacity: 0, easing: 'easeInOutQuad' }, delayBetweenVotesMs - 500)
                break;


        case 'red':

            // Removing Event Listeners
            buttonVoteGreen.removeEventListener('click', onClickGreen)
            buttonVoteYellow.removeEventListener('click', onClickYellow)
            buttonVoteRed.removeEventListener('click', onClickRed)

            changeColor(messageDisplay, '#FFFFFF')
            show(messageDisplay)

            // "Non-Clickable" cursor
            changeCursors([buttonVoteGreen, buttonVoteYellow, buttonVoteRed], 'default')

            // Animation
            let redVoteAnimation = anime.timeline({
                easing: 'cubicBezier(0, .7, .2, 1)',
                duration: 500,
                complete: function () {
                    redirectTo(`increment-vote.php?type=${voteAs}&id=${eventId}&feedback=${voteType}`)
                }
            })
            .add({ targets: 'body', backgroundColor: colorRed }, 0)
            .add({ targets: [buttonVoteGreen, buttonVoteYellow], color: colorRed }, 0)
            .add({ targets: voteTypeDisplay, opacity: 0 }, 0)
            .add({ targets: messageDisplay, opacity: 1, easing: 'easeInOutQuad' }, '+= 25')
            .add({ targets: 'body', backgroundColor: colorDarker }, delayBetweenVotesMs)
            .add({ targets: buttonVoteGreen, color: colorGreen }, delayBetweenVotesMs)
            .add({ targets: buttonVoteYellow, color: colorYellow }, delayBetweenVotesMs)
            .add({ targets: voteTypeDisplay, opacity: 1 }, delayBetweenVotesMs)
            .add({ targets: messageDisplay, opacity: 0, easing: 'easeInOutQuad' }, delayBetweenVotesMs - 500)
            break;


    }
}



function initialize() {
    hide(messageDisplay)
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