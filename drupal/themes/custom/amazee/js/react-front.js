class Button2 extends React.Component {
    constructor(props){
        super(props)
        this.onClickHandler = this.onClickHandler.bind(this)
    }

    onClickHandler(){
        this.props.onClick("Button2")
    }

    render() {
        var pageURL = window.location.href;
        var lastURLSegment = pageURL.substr(pageURL.lastIndexOf('/') + 1);
        return (
            <button onClick={this.onClickHandler} id="button2">
            {lastURLSegment}
            </button>
    )



    }
}

class Button1 extends React.Component {

    constructor(props){
        super(props)
        this.onClickHandler = this.onClickHandler.bind(this)
    }

    onClickHandler(){
        this.props.onClick('Button1')
    }

    render() {
        return (
            <button onClick={this.onClickHandler} id="button1">
            Click to show the result again!
        </button>
    )
    }
}

class App extends React.Component {
    constructor(props){
        super(props)
        this.state = {
            showButton : true,
            hide: false
        }
        this.changeButtonState = this.changeButtonState.bind(this)
        this.getButton = this.getButton.bind(this)
        this.transitionEndEventName = this.transitionEndEventName.bind(this)
        this.hideApp = this.hideApp.bind(this)
        this.removeEvent = this.removeEvent.bind(this)
    }

    getButton() {
        if (this.state.showButton){
            return <Button1 onClick={this.hideApp}/>
        } else {
            return <Button2 onClick={this.hideApp}/>
        }
    }

    transitionEndEventName () {
        var el = document.createElement('div')//what the hack is bootstrap

        var transEndEventNames = {
            WebkitTransition : 'webkitTransitionEnd',
            MozTransition    : 'transitionend',
            OTransition      : 'oTransitionEnd otransitionend',
            transition       : 'transitionend'
        }

        for (var name in transEndEventNames) {
            if (el.style[name] !== undefined) {
                return transEndEventNames[name];
            }
        }

        return false // explicit for ie8 (  ._.)
    }


    hideApp(button) {
        var app = document.getElementById('main')
        var transitionEnd = this.transitionEndEventName()
        app.addEventListener(transitionEnd, this.removeEvent, false)
        app.classList.contains('show-element') ? app.classList.remove('show-element') : null
        app.classList.add('remove-element')
    }

    removeEvent(){
        console.log('hey')
        var app = document.getElementById('main')
        var transitionEnd = this.transitionEndEventName()
        app.removeEventListener(transitionEnd, this.removeEvent, false)
        this.changeButtonState()
    }

    changeButtonState(button) {
        this.setState({
            showButton: !this.state.showButton,
            hide: true
        })
    }

    componentDidUpdate(){
        var app = document.getElementById('main')
        app.classList.contains('remove-element') ? app.classList.remove('remove-element') : null
        app.classList.add('show-element')
    }

    render(){
        var button = this.getButton()
        return (
            <div id="button-container">
            {button}
            </div>
    )
    }
}

ReactDOM.render(<App />, document.getElementById('main'))
