/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';


/*import useMetaMask from "metamask-react";

import React from 'react';
function App() {
    const { status, connect, account } = useMetaMask();

    if (status === "initializing") return <div>Synchronisation with MetaMask ongoing...</div>

    if (status === "unavailable") return <div>MetaMask not available :(</div>

    if (status === "notConnected") return <button onClick={connect}>Connect to MetaMask</button>

    if (status === "connecting") return <div>Connecting...</div>

    if (status === "connected") return <div>Connected account: {account}</div>

    return null;
}*/

/*
console.log(window.ethereum);

function App() {
    const ethereum=window.ethereum;
    if(ethereum){
        ethereum.on('accountsChanged',function (accounts){
           console.log(accounts[0]);
        });
    }
    console.log('111');
}
App();*/
