import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import Modal from './components/modal'
import '../styles/app.css';
import './scrollReveal'

const arrEditProfil = []
const data = document.getElementById('root').dataset
//const $ = require('jquery');

if (data) {
    arrEditProfil.push(data)
}

ReactDOM.render(
    <Router>
    </Router>, document.getElementById('root')
);