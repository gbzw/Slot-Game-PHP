<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slot</title>
    <style>

        *{
            box-sizing: border-box;
            font-size:15px;
            margin:0;
            padding:0;
            font-family: 'Helvetica';
            outline:none;
            border:none;
        }

        html{
            color:white;
            min-height: 100%;
        }

        body{
            width:100%;
            min-height:100vh;
            overflow-y: scroll;
            background:rgb(58, 58, 58);
        }

        a{
            color:white;
            padding:0.6em;
        }

        .slotHolder{
            max-width:580px;
            margin:2em auto;
        }

        a.button{
            margin: 0.6em 0;
            display:block;
            width:100%;
            padding:0.6em;
            color:white;
            text-align:center;
            background:rgb(79, 79, 211);
            border-radius:0.4em;
            text-decoration:none;
        }

        a.button:hover{
            background:rgb(73, 73, 194);
        }

        a.button:active{
            background:rgb(88, 88, 224);
        }

        .slotMachine{
            position: relative;
            display:flex;
            flex-direction:row;
            width:100%;
            background-color: rgb(79, 79, 79);
            border-radius:0.4em;
        }

        .slotRow{
            display:flex;
            flex-direction:column;
            width:20%;
        }

        .slotRow div{
            display: inherit;
            justify-content:center;
            align-items:center;
            margin:0.6em;
            padding:0.6em;
            background-color: #666;
            border-radius:0.4em;
            height:120px;
        }

        .slotRow div img{
            max-width:100%;
            max-height:100%;
            object-fit:contain;
        }

        ol li{
            padding:0.4em;
        }

    </style>
</head>
<body>