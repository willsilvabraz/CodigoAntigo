*{
    box-sizing: border-box;
    padding: 0;
    margin: 0;
}

.col-lg-6 h1{
    flex-direction: column;
    padding: 5px 0px 17px;
}

.form-group .form-control{
    background-color: #00000054;
}

.col-lg-6 button{
    margin: 1.7rem;
    transition: .2s;
    background-color: red;
}

.col-lg-6 button:hover{
    transform: scale(1.05);
}

.table-responsive thead tr th{
    align-items: center;
    justify-content: space-between;
    padding: 0px 18px;
}

.table-responsive tbody tr td{
    align-items: center;
    justify-content: space-between;
    padding: 0px 18px;
}

@media screen and (max-width: 1020px){
    .container{
        flex-direction: column;
    }

    .col-lg-6 h1{
        font-size: 40px;
        line-height: 50px;
    }
    
    .table-responsive thead tr th{
        align-items: center;
        justify-content: space-between;
        padding: 0px 18px;
    }

}