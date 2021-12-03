import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import Modal from './components/modal'
import '../styles/app.css';
import './scrollReveal'

const arrEditProfil = []
const data = document.getElementById('root').dataset

if (data) {
    arrEditProfil.push(data)
}

console.log(arrEditProfil)

ReactDOM.render(
    <Router>
        <Modal 
            title='Editer mon profil'
            content={arrEditProfil}
            modaltitle='Editer mon profil'
        />
    </Router>, document.getElementById('root')
);