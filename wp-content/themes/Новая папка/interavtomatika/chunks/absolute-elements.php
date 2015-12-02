<div class="absolute-elements">

	<div class="opacity display-none"></div>

    <div id="callback-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">ОБРАТНЫЙ ЗВОНОК</h4>
                </div>
                <div class="modal-body with-form">
                    <form action="callback.php">
	                    <div class="input-wrap input-required">
                            <input type="text" name="name" placeholder="Контактное лицо" data-validation-mask="moreThen3Char"/>
	                    </div>
                        <br/>
	                    <div class="input-wrap input-required">
	                        <input type="text" name="phone" placeholder="38 (050) 123-12-12" data-validation-mask="phone"/>
	                    </div>
	                    <button class="cancel" data-dismiss="modal">Отмена</button>
	                    <button class="send" >Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="road-map-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"></h4>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <div id="general-modal-window" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"></h4>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

	<div id="product-comment" class="modal-product-comment modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">ОТЗЫВ О ПРИБОРЕ</h4>
				</div>
				<div class="modal-body with-form clearfix">

					<div class="title">
						<div class="big-stars">
							<div class="big-yellow-stars">
								<div class="wrap">
									<div class="icon-big-yellow-star"></div>
									<div class="icon-big-yellow-star"></div>
									<div class="icon-big-yellow-star"></div>
									<div class="icon-big-yellow-star"></div>
									<div class="icon-big-yellow-star"></div>
								</div>
							</div>
							<div class="big-grey-stars">
								<div class="wrap">	
									<div class="icon-big-grey-star"></div>
									<div class="icon-big-grey-star"></div>
									<div class="icon-big-grey-star"></div>
									<div class="icon-big-grey-star"></div>
									<div class="icon-big-grey-star"></div>
								</div>
							</div>
						</div>
						<span>Оцените качество товара</span>
					</div>

					<form action="product-comment.php">
						<div class="input-wrap input-required">
							<textarea name="comment" placeholder="Ваше сообщение:" data-validation-mask="moreThen3Char"></textarea>
						</div>
						<br/>
						<div  class="input-wrap input-required">
							<input type="text" name="name" placeholder="Ваше имя:" data-validation-mask="moreThen3Char"/>
						</div>
						<br/>
						<div class="input-wrap input-required">
							<input type="text" name="email" placeholder="Ваш E-mail:" data-validation-mask="email"/>
						</div>

						<div class="checkbox-item">
							<input type="checkbox" name="inform-about-response" id="inform-about-response" checked="true">
							<label for="inform-about-response" class="glyphicon"></label>
							<div class="title">
								<label for="inform-about-response">Уведомлять об ответах на E-mail</label>
							</div>
						</div>

						<div class="buttons-wrap">
							<button class="cancel" data-dismiss="modal">Отмена</button>
							<button class="send" >Отправить</button>
						</div>

					</form>

					<span class="note">Важно! Ваш отзыв или коментарий добавляется на сайт, после прохождения модерации. Спасибо за Ваше участие</span>
				</div>
			</div>
		</div>
	</div>

	<div id="response-to-comment" class="modal-product-comment modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">ОТВЕТИТЬ НА ОТЗЫВ</h4>
				</div>
				<div class="modal-body with-form clearfix">

					<form action="product-comment.php">
						<div class="input-wrap input-required">
							<textarea name="comment" placeholder="Ваше сообщение:" data-validation-mask="moreThen3Char"></textarea>
						</div>
						<br/>
						<div  class="input-wrap input-required">
							<input type="text" name="name" placeholder="Ваше имя:" data-validation-mask="moreThen3Char"/>
						</div>
						<br/>
						<div class="input-wrap input-required">
							<input type="text" name="email" placeholder="Ваш E-mail:" data-validation-mask="email"/>
						</div>

						<div class="buttons-wrap">
							<button class="cancel" data-dismiss="modal">Отмена</button>
							<button class="send" >Отправить</button>
						</div>

					</form>

					<span class="note">Важно! Ваш отзыв или коментарий добавляется на сайт, после прохождения модерации. Спасибо за Ваше участие</span>
				</div>
			</div>
		</div>
	</div>

	<div id="cart-popup" class="modal-cart modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<div class="icon-white-cart"></div>
					<h4 class="modal-title">КОРЗИНА</h4>
				</div>
				<div class="modal-body clearfix">

					<div class="title clearfix">
						<h4>Выбранные товары:</h4>
						<a href="/products/products.php" class="back-to-catalog link-button">Вернутся в каталог</a>
						<div class="delete-all-products link-button" data-delete-confirm-text="Удалить все товары из корзины">Удалить все товары</div>
					</div>

					<div class="search-results-products">

						<div class="results-products-items" data-delete-confirm-text="Удалить товар из корзины">

							<div class="results-product-item">
								<div class="backlight-cells">
									<div class="backlight-cells-row">
										<div class="photo">
											<a href="#" class="img-wrap">
												<img src="<?php echo get_template_directory_uri(); ?>/images/demo/search-product.png" alt=""/>
											</a>
										</div>
										<div class="product-denomination">
											<div class="wrap">
												<a href="#">
													ООО "Интеравтоматика" с 2007 года является официальным
													дистрибьютором международного
													концерна OEM Automatic, имеющего филиалы в двенадцати
													европейских странах и более
												</a>
											</div>
										</div>
										<div class="product-number">IME-0868ОПГ88</div>
										<div class="manufacturer">
											<div class="wrap">
												<div class="name"><span>ABIBAS</span></div>
												<a href="/docs/guid.pdf" class="file">
													<div class="small-image-pdf">PDF</div>
													<div class="size-text">(118 kb)</div>
												</a>
											</div>
										</div>
									</div>
								</div>
								<div class="quantity">
									<div class="plus">+</div>
									<input type="text" class="number-field" value="1" />
									<div class="minus">-</div>
								</div>
								<div class="delete-cell">
									<div class="delete-button">
										<div class="icon-close-button-cart-page-grey"></div>
										<div class="icon-close-button-cart-page-red"></div>
									</div>
								</div>
							</div>

							<div class="results-product-item">
								<div class="backlight-cells">
									<div class="backlight-cells-row">
										<div class="photo">
											<a href="#" class="img-wrap">
												<img src="<?php echo get_template_directory_uri(); ?>/images/demo/search-product.png" alt=""/>
											</a>
										</div>
										<div class="product-denomination">
											<div class="wrap">
												<a href="#">
													ООО "Интеравтоматика" с 2007 года является официальным
													дистрибьютором международного
													концерна OEM Automatic, имеющего филиалы в двенадцати
													европейских странах и более
												</a>
											</div>
										</div>
										<div class="product-number">IME-0868ОПГ88</div>
										<div class="manufacturer">
											<div class="wrap">
												<div class="name"><span>ABIBAS</span></div>
												<a href="/docs/guid.pdf" class="file">
													<div class="small-image-pdf">PDF</div>
													<div class="size-text">(118 kb)</div>
												</a>
											</div>
										</div>
									</div>
								</div>
								<div class="quantity">
									<div class="plus">+</div>
									<input type="text" class="number-field" value="1" />
									<div class="minus">-</div>
								</div>
								<div class="delete-cell">
									<div class="delete-button">
										<div class="icon-close-button-cart-page-grey"></div>
										<div class="icon-close-button-cart-page-red"></div>
									</div>
								</div>
							</div>

						</div>

					</div>
					
					<div class="go-to-checkout">
						<a href="/cart/cart.php" class="green-button active">ОФОРМИТЬ ЗАКАЗ</a>
					</div>

					<div class="notice">Важно! В связи с колебанием курса валют, стоимость обарудования, уточняйте у менеджера по телефонам указанным на сайте.</div>

				</div>
			</div>
		</div>
	</div>

	<div id="clarify-cost" class="modal-clarify-cost modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">УТОЧНИТЬ СТОИМОСТЬ</h4>
				</div>
				<div class="modal-body with-form clearfix">

					<span class="instruction">Заполните (на выбор) контактную информацию для связи с Вами. В ближайшее время наш менеджер сообщит на указанный контакт актуальную стоимость оборудования</span>

					<form action="clarify-cost.php">

						<div class="form-item phone">
							<span class="title">Перезвонить на номер</span>
							<div class="input-wrap input-required">
								<input type="text" name="phone" data-validation-mask="phone" placeholder="+3 (123) 456-78-00">
							</div>
						</div>
						<span class="or">ИЛИ</span>
						<div class="form-item email">
							<span class="title">Выслать на E-mail</span>
							<div class="input-wrap input-required">
								<input type="text" name="email" data-validation-mask="email" placeholder="Ваш E-mail:">
							</div>
						</div>

						<div class="buttons-wrap">
							<button class="cancel" data-dismiss="modal">Отмена</button>
							<button class="send" >Отправить</button>
						</div>

					</form>

					<span class="note">Важно! Ваш отзыв или коментарий добавляется на сайт, после прохождения модерации. Спасибо за Ваше участие</span>
				</div>
			</div>
		</div>
	</div>


</div>
