<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');



    body {
        font-family: 'Poppins', sans-serif;
    }

    .btn {
        border-radius: 0px;
        font-size: 11px !important;
    }

    .btn-home {
        background-color: #62CDFF;
        border: 1px solid #62CDFF;
        color: black;
        padding: 5px 10px;
        font-weight: 600;
        border: none !important;
        font-size: 12px;
    }

    .btn-home:hover {
        background-color: #62CDFF;
        border: 1px solid #62CDFF;
        color: black;
        padding: 5px 10px;
        font-weight: 600;
        border: none !important;
        font-size: 12px;
    }

    .btn-back {
        background-color: #56DFCF;
        color: black;
        padding: 5px 10px;
        font-weight: 600;
        border: 1px solid #56DFCF;
        font-size: 12px;
    }

    .btn-back:hover {
        background-color: #56DFCF;
        color: black;
        padding: 5px 10px;
        font-weight: 600;
        border: 1px solid #56DFCF;
        font-size: 12px;
    }




    * a {
        text-decoration: none !important;
    }

    a {
        text-decoration: none !important
    }






    .btn {
        border-radius: 0px !important;
    }


    .table {
        border: 0.5px solid grey !important;
    }

    .table th {
        font-size: 12px !important;
        border: none !important;
        background-color: #1B7BBC !important;
        color: white !important;
        padding: 6px 5px !important;
        font-weight: 500;
    }

    .table td {
        font-size: 11px;
        color: black;
        padding: 7px 5px !important;
        font-weight: 500;
        border: none !important
    }

    .hr-table {
        table-layout: auto !important;
        min-width: max-content !important;
    }

    .hr-table td {
        font-size: 11px !important;
        white-space: normal !important;
        word-break: break-word !important;
        overflow-wrap: break-word !important;
        max-width: 700px !important;
    }

    .hr-table th {
        font-size: 12px !important;
        background-color: #BBE1FA !important;
        font-weight: 600 !important;
    }

    .table tr {
        border-color: #9a8c98
    }

    .table-responsive {
        max-height: 500px;
        /* set a scrollable height */
        overflow-y: auto;
        /* vertical scroll */
    }

    .table thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        /* keeps header above table body */
        font-size: 12px !important;
        border: none !important;
        background-color: #1B7BBC !important;
        color: white !important;
        padding: 6px 5px !important;
        font-weight: 500;
    }


    .btn-fixed-text,
    .btn-fixed-text:hover {
        white-space: nowrap !important;
        font-size: 11px !important;
        font-weight: 500 !important;
        background-color: #70d6ff;
        color: black !important;

        transition: all 0.3s ease !important;
        padding: 4px 10px !important;
        color: black !important;
        /* border: 1px solid #0DCAF0 !important; */
    }

    .btn-fixed-text:hover {
        filter: brightness(85%) !important;
    }

    /* Approve Button  */
    .btn-approve,
    .btn-approve:hover {
        white-space: nowrap !important;
        font-size: 10.5px !important;
        font-weight: 500 !important;

        transition: all 0.3s ease !important;
        color: black !important;
        border: none;
        padding: 4px 10px !important;
        background-color: #7de2d1;
    }

    .btn-approve:hover {
        filter: brightness(85%);
    }


    /* Reject Button */
    .btn-reject,
    .btn-reject:hover {
        white-space: nowrap !important;
        font-size: 10.5px !important;
        font-weight: 500 !important;
        color: white !important;
        transition: all 0.3s ease !important;

        border: none;
        padding: 4px 10px !important;
        background-color: #e63946;
    }

    .btn-reject:hover {
        filter: brightness(85%);
    }


    .btn-uploadevidence {
        font-size: 12px !important;
        font-weight: 500 !important;
        background-color: white;
        color: black !important;
        border-radius: 15px !important;
        transition: all 0.3s ease !important;
        padding: 4px 15px !important;
        border: 1px solid black !important;
    }

    .btn-uploadevidence:hover {
        filter: brightness(85%) !important;
    }

    .btn-viewevidence {
        font-size: 12px !important;
        font-weight: 500 !important;
        background-color: #7F7C82;
        color: white !important;
        border-radius: 15px !important;
        transition: all 0.3s ease !important;
        padding: 4px 15px !important;
        border: 1px solid black !important;
    }

    .btn-viewevidence:hover {
        filter: brightness(85%) !important;
    }

    /* staff list */
    .filter-wrapper {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
        background-color: #cfe2ff;
    }

    .home-button {
        margin-right: 20px;
    }

    .filter-container {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .filter-item {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }

    .filter-container select,
    .filter-container input {
        padding: 6px 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        height: 35px;
        background-color: #FFFCFB;
    }

    .filter-container input:focus,
    .filter-container select:focus {
        outline: none;
        border-color: #0D9276;
    }

    .filter-container #filter {
        width: 200px;
    }

    .btn-input-text {

        white-space: nowrap !important;
        font-size: 10.5px !important;
        font-weight: 500 !important;
        color: white !important;
        transition: all 0.3s ease !important;
        color: black !important;
        border: none;
        padding: 4px 10px !important;
        background-color: #dee2e6;
    }

    .btn-input-text:hover {
        filter: brightness(85%) !important;
    }

    .btn-cc_edit {
        font-size: 12px !important;
        font-weight: 500 !important;
        background-color: #FEECB3;
        color: white !important;
        border-radius: 15px !important;
        transition: all 0.3s ease !important;
        padding: 4px 15px !important;
        color: black !important;
        border: 1px solid black !important;
    }

    .btn-cc_edit:hover {
        filter: brightness(85%) !important;
    }

    .btn-addcomment {
        font-size: 12px !important;
        font-weight: 500 !important;
        background-color: #DFD3C3;
        color: white !important;
        border-radius: 15px !important;
        transition: all 0.3s ease !important;
        padding: 4px 15px !important;
        color: black !important;
        border: 1px solid #D0B8A8 !important;
    }

    .btn-addcomment:hover {
        filter: brightness(85%) !important;
    }
</style>



<style>
    .desc-card h3 {
        font-size: 20px !important;
        font-weight: bold !important;
    }

    .desc-card h6 {
        font-size: 17px !important;
        font-weight: bold !important;
    }

    .desc-card p {
        font-size: 14.5px !important;
    }
</style>


<style>
    .table-hr th {
        font-size: 15px !important;
        font-weight: 400 !important;
    }

    .table-hr td {
        font-size: 10px !important;
        padding: 0;

    }

    .filter-wrapper-hr {
        background-color: #B7C4CF !important;
    }
</style>


<style>
    .filtercard label {
        margin: 0;
        margin-bottom: 2px;
        font-size: 13px !important;
        color: black;
        font-weight: 500;
    }

    .filtercard input,
    select,
    option {
        font-size: 12px !important;
        font-weight: 500;
    }

    .itacc-div label {
        margin: 0!important;
        margin-bottom: 2px!important;
        font-size: 13px !important;
        color: black!important;
        font-weight: 600!important;
    }

    .itacc-div input,
    select,
    option {

        font-size: 13px !important;
        color: #495057 !important;
    }
</style>

<style>
      .hr-div label {
        margin: 0;
        margin-bottom: 2px;
        font-size: 13px !important;
        color: black;
        font-weight: 600;
    }

    .hr-div input,
    select,
    option {

        font-size: 13px !important;
        color: #495057 !important;
    }
</style>

<style>
      .cash-forms label {
        margin: 0;
        margin-bottom: 2px;
        font-size: 13px !important;
        color: black;
        font-weight: 600;
    }

    .cash-forms input,
    select,
    option {

        font-size: 13px !important;
        color: #495057 !important;
    }
</style>


<style>
     .bg-menu {
            background-color: #393E46 !important;
        }

        .btn-menu {
            font-size: 12.5px;
            background-color: #FFB22C !important;
            padding: 5px 10px;
            font-weight: 600;
            border: none !important;
        }
</style>