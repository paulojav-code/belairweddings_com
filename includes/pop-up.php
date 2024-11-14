<dialog class="pop_up" id="popup" open> 
    <a><i class="fa-solid fa-xmark" id="close_dialog"></i></a>
    <img class="img_popup" src="assets/img/popups/10 DESCUENTO_KGNV_POP UP_POPUP_CABOS.png" alt="">
</dialog>
<script>
    document.querySelector("#close_dialog").addEventListener('click',function(){
        document.querySelector("#popup").close();
    })
</script>
<style>
    .pop_up{
					z-index: 999;
					padding: 0;
					box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px;
					border: none;
					
					& img{
						width: 100%;
						height: 100%;
						object-fit: cover;
						z-index: 1;
					}
					& a{
						position: absolute;
						right: 0.5em;
						border-bottom:none;
						& i{
							font-size: 2em;
							color: #fff;
							border: none;
							
						}
					}
					& a:hover{
						transform: scale(1.1);
						cursor: pointer;
					}
				}
				#popup::backdrop{
					z-index: 2;
					background-color: rgba(0, 0, 0, 0.55);
				}
</style>