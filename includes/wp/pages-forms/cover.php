<?php
?>
<section class="cover">
    <header>
        <ul>
            <li><a href="<?= SERVER_URL ?>" class="logo"><img src="<?= $back ?>assets/img/logos/dreams-wedding_logo_bco.png" alt="Logo Dreams Wedding"></a></li>
            <?= $flag? '<li><a href="'.URL.$flag[1].'"><img src="'.$back.'assets/img/wp/flag_'.$flag[0].'.png" alt="Logo Flag"></a></li>':'' ?>
        </ul>
    </header>
    <div>
        <h1><span><?= $wp['person_1'] ?></span><span><?= $wp['conector'] ?></span><span><?= $wp['person_2'] ?></span></h1>
        <h2>19 de Octubre 2024 - Puerto Vallarta, Jal.</h2>
        <h3>211<span>d</span> 10<span>h</span> 04<span>m</span> 51<span>s</span></h3>
        <h4>"Sé parte del viaje de nuestra vida juntos"</h4>
    </div>
</section>
<style>
        .cover{
            & header{
                & ul{
                    position: absolute;width:100%;z-index:100;
                    display:flex;flex-direction:row;flex-wrap:wrap;
                    & li{
                        width:50%;padding:1em;
                        & .logo{
                            display: block;
                            width:9em;
                            height:9em;
                            background: #7d8d8fcc;
                            background: #a9aab1cc;
                            border-radius:50%;
                            padding-top:0.875em;
                            transition: background 0.5s;
                            & img{
                                display:block;width:7em;margin:0 auto;
                                @media screen and (max-width: 480px){width:8em;}
                            }
                            &:hover{
                                background: #7d8d8f;
                                background: #a9aab1;
                            }
                        }
                        &:nth-child(2){
                            text-align:right;
                            padding:2em;
                            & img{width:3.5em;border-radius:0.5em;}
                        }
                    }
                }
            }
            & div{
                display: flex;
                flex-direction: column;
                justify-content: flex-star;
                align-items: center;
                position: relative;
                width:100%;
                min-height:100dvh;
                /* , */
                background-image: url('<?= $wp_img['cover'] ?>');
                background-position: 50% 50%;
                background-attachment: fixed;
                padding-top:calc(100dvh - 18em);
                padding-bottom:5em;
                &::after{
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: 1;
                    background: linear-gradient(to bottom, #00000000 30%, #00000040 80%);
                }
                & h1,& h2,& h3, & h4{
                    color:#fff;
                    z-index:2;
                }
                & h1{
                    font-size:5.5em;
                    font-family: "Fraunces", serif;
                    display: flex;
                    flex-direction: row;
                    justify-content: flex-start;
                    & span{
                        &:nth-child(1){
                            line-height:1em;
                        }
                        &:nth-child(2){
                            font-size:2em;
                            line-height:1em;
                            padding:0 0.125em;
                            color:#a9aab1;
                        }
                        &:nth-child(3){
                            line-height:1em;
                            align-self: flex-end;
                        }
                    }
                }
                & h2{
                    font-size:1.75em;
                    font-family: "Fraunces", serif;
                    line-height:1em;
                    margin:1em 0 3em 0;
                }
                & h3{
                    font-size:3.5em;
                    font-family: "Fraunces", serif;
                    border-top: solid 1px;
                    line-height:1em;
                    padding:1.5em 0;
                    & span{
                        margin-right:0.5em;
                    }
                }
                & h4{
                    font-size:2em;
                    font-family: "Fraunces", serif;
                    font-style: italic;
                }
            }
        }
    </style>