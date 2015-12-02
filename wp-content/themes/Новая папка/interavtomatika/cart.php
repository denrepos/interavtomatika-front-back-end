<?php
/*
Template Name: Мой шаблон страницы
*/
?>
<!DOCTYPE html>
<html>
<?php include '../head.php' ?>
<body class="cart-page">
	<?php include '../header.php' ?>
	<div class="container-fluid middle-container-wrap">
		<div class="middle-container">
			<div class="content col-lg-16 col-lg-push-4">
				<div class="products-in-cart">

					<div class="products-in-cart-title clearfix">

						<h1 class="main-page-title">Товары в корзине (3):</h1>

						<div class="to-the-favorites">
							<div class="icon-favorites-star"></div>
							<span>В избранное</span>
						</div>

						<a href="/products/products.php" class="back-to-catalog">Вернуться в каталог</a>

					</div>

					<div class="search-results-products">

						<div class="results-products-items" data-delete-confirm-text="Удалить товар из корзины">
							<div class="search-product-items-header">
								<div class="backlight-cells">
									<div class="backlight-cells-row clearfix">
										<div class="photo">
											<span>ФОТО</span>
										</div>
										<div class="product-denomination">
											<span>НАМИЕНОВАНИЕ ТОВАРА</span>
										</div>
										<div class="manufacturer">
											<span>ПРОИЗВОДИТЕЛЬ</span>
										</div>
										<div class="product-number">
											<span>АРТИКУЛ</span>
										</div>
									</div>
								</div>
								<div>
									<span>КОЛИЧЕСТВО</span>
								</div>
								<div class="cart">
								</div>
							</div>

							<div class="results-product-item">
								<div class="backlight-cells">
									<div class="backlight-cells-row">
										<div class="photo">
											<a href="#" class="img-wrap">
												<img src="../images/demo/search-product.png" alt=""/>
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
												<img src="../images/demo/search-product.png" alt=""/>
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
				</div>

				<div class="ordering" id="ordering">

					<h4 class="ordering-title">Оформление заказа</h4>

					<div class="ordering-step-1 panel collapse-marker" class="os-title collapse-marker" data-target="#os-1-content">

						<hr/>
						<div class="os-title">Контактные данные</div>
						<div class="os-edit-button link-button" data-toggle="collapse" data-parent="#ordering" data-target="#os-1-content">Редактровать</div>

						<ul class="nav">
							<li class="active">
								<div data-toggle="tab" data-target="#legal-entity" aria-expanded="false" class="cart-button">Для юридических лиц</div>
							</li>
							<li class="">
								<div data-toggle="tab" data-target="#individual-entity" aria-expanded="true" class="cart-button">Для физических лиц</div>
							</li>
						</ul>

						<div class="os-1-content collapse in" id="os-1-content"  >

							<div class="tab-content">


								<div id="legal-entity" class="tab-pane fade active in">

									<form>

										<div class="item-title">Информация для запроса счета</div>

										<div class="form-item organization-name">
											<span class="title">Наименование организации</span>
											<div  class="input-wrap input-required">
												<input value="test" type="text" name="organization-name" data-validation-mask="moreThen3Char" placeholder='ООО "Три кита"' />
											</div>
										</div>

										<div class="form-item contact-person">
											<span class="title">Контактное лицо</span>
											<div  class="input-wrap">
												<input type="text" name="contact-person" data-validation-mask="moreThen3Char" placeholder="Иван Иванов" />
											</div>
										</div>
										<div class="form-item send-me-invoice">
											<span class="title">Отправить мне счет на (выбор)</span>
											<div  class="input-wrap input-required">
												<input value="123123123123" type="text" name="invoice-fax" data-validation-mask="phone" placeholder="Факс" />
												<input type="text" name="invoice-email" data-validation-mask="email" placeholder="E-mail" />
											</div>
										</div>

										<div class="checkbox-item">
											<input type="checkbox" name="include-shopping" id="include-shopping" checked="true"/>
											<label for="include-shopping" class="glyphicon"></label>
											<div class="title">
												<label for="include-shopping"> Включить в счет доставку</label>
											</div>
										</div>

										<div class="form-item tax-invoice">
											<span class="title">Телефон для налоговой накладной</span>
											<div  class="input-wrap">
												<input type="text" name="phone" placeholder="(123) 456-78-90" />
											</div>
										</div>
										<div class="payer-certificate clearfix">
											<span class="title">Свидетельство плательщика НДС или ФОП</span>
											<div class="download-button">
												<div class="green-button active light-shadow">Загрузить файл</div>
											</div>
											<div class="file-name"><span title="Свидетельство плательщика Свидетельство плательщика Свидетельство плательщика Свидетельство плательщика Свидетельство плательщика Свидетельство плательщика ">Свидетельство плательщика Свидетельство плательщика Свидетельство плательщика Свидетельство плательщика Свидетельство плательщика Свидетельство плательщика </span><div class="close"></div></div>
											<div class="file-name"><span title="Свидетельство плательщика">Свидетельство плательщика</span><div class="close"></div></div>
											<div class="file-name"><span title="Свидетельство плательщика">Свидетельство плательщика</span><div class="close"></div></div>
										</div>

										<div class="checkbox-item send-invoice-without-shipping">
											<input type="checkbox" name="send-invoice-without-shipping" id="send-invoice-without-shipping"/>
											<label for="send-invoice-without-shipping" class="glyphicon"></label>
											<div class="title">
												<label for="send-invoice-without-shipping">Отправить счет менеджеру, без выбора доставки и оплаты</label>
											</div>
										</div>
										<div class="next-checkout-buttons-wrap">
											<div class="next-button green-button" data-toggle="collapse" data-parent="#ordering" data-target="#os-2-content">Далее</div>
											<div class="checkout-block display-none">
												<div class="checkout-button green-button" >Оформить заказ</div>
												<div class="user-agreement-title">Я подтверждаю заказ и принимаю условия<br/><a href="#">пользовательского соглашения</a></div>
											</div>
										</div>
									</form>
								</div>

								<div id="individual-entity" class="tab-pane fade">

									<form>

										<div class="form-item contact-person">
											<span class="title">Контактное лицо</span>
											<div class="input-wrap"><input type="text" name="contact-person" placeholder="Иван Иванов" /></div>
										</div>

										<div class="form-item phone">
											<span class="title">Контактный телефон</span>
											<div class="input-wrap input-required"><input value="123123123123" data-validation-mask="phone" type="text" name="phone" placeholder="(123) 456-78-90" /></div>
										</div>

										<div class="form-item email">
											<span class="title">E-mail</span>
											<div  class="input-wrap">
												<span class="remark">Следить за статусом выполнения заказов</span>
												<input type="text" name="email" placeholder="admin@admin.com"/>
											</div>
										</div>

										<div class="next-checkout-buttons-wrap">
											<div class="next-button green-button" data-toggle="collapse" data-parent="#ordering" data-target="#os-2-content">Далее</div>
										</div>

									</form>

								</div>

							</div>
						</div>

					</div>

					<div class="ordering-step-2 panel collapse-marker" data-parent="#ordering" data-target="#os-2-content">

						<hr/>
						<div class="os-title" >Выбор способа доставки и оплаты</div>

						<div class="os-2-content collapse" id="os-2-content">

							<div class="item-title"><span class="info">i</span>Доставка товара</div>

							<ul class="nav">
								<li class="active">
									<div data-toggle="tab" data-target="#self-pickup" aria-expanded="true" class="cart-button">Самовывоз</div>
								</li>
								<li class="">
									<div data-toggle="tab" data-target="#courier" aria-expanded="false" class="cart-button">Новая почта</div>
								</li>
							</ul>

							<div class="tab-content">

									<div id="self-pickup" class="tab-pane fade active in">

										<form id="form-self-pickup">

											<div class="shipping-wrap">	
												<div class="form-item">
	
													<input type="radio" name="shipping" value="self-pickup" id="shipping_self-pickup" checked="true" class="display-none" />
													<label for="shipping_self-pickup" class="custom-radio"></label>
													<label for="shipping_self-pickup">Со склада</label>
													<span class="see-on-map link-button" onclick="$('header .contacts-header .road-map').click()">см. на карте</span>
	
												</div>
											</div>

											<div class="form-item address">Адрес:49000, г.Днепропетровск, ул.Паникахи, д.2</div>

											<div class="payment-methods">

												<div class="item-title"><span class="info">i</span>Оплата товара</div>

												<div class="for-individual-entity input-required display-none">
													<div class="payment-methods_cash-money form-item">
														<input type="radio" id="payment-methods_cash-money" name="individual_payment-methods" value="cash-money" class="display-none" />
														<label for="payment-methods_cash-money" class="custom-radio"></label>
														<label class="required-highlight" for="payment-methods_cash-money">Наличными</label>
													</div>
													<div class="payment-methods_on-bank-card form-item">
														<input type="radio" id="payment-methods_on-bank-card" name="individual_payment-methods" value="on-bank-card" class="display-none" />
														<label for="payment-methods_on-bank-card" class="custom-radio"></label>
														<label class="required-highlight" for="payment-methods_on-bank-card">На карту банка</label>
													</div>
												</div>

												<div class="for-legal-entity">
													<div class="payment-methods_non-cash-payment form-item">
														<input type="radio" id="payment-methods_non-cash-payment" name="legal_payment-methods" value="non-cash-payment" checked="true" class="display-none" />
														<label for="payment-methods_non-cash-payment" class="custom-radio"></label>
														<label for="payment-methods_non-cash-payment">Безналичными</label>
													</div>
												</div>

												<div class="checkout-block">
													<div class="checkout-button green-button" >Оформить заказ</div>
													<div class="user-agreement-title">Я подтверждаю заказ и принимаю условия<br/><a href="#">пользовательского соглашения</a></div>
												</div>

											</div>

											<div class="add-comment">
												<div class="link-button add-comment-title" data-text="Скрыть коментарий к заказу">Добавить коментарий к заказу</div>
												<div class="textarea-wrap display-none"><textarea class="sdisplay-none" name="comment" id="comment" cols="60" rows="5"></textarea></div>
											</div>

										</form>

									</div>

									<div id="courier" class="tab-pane fade courier">

										<form id="courier">

											<div class="shipping-wrap">

												<div class="form-item">

													<input type="radio" name="shipping" value="new-post" id="shipping_new-post" checked="true" class="display-none" />
													<label for="shipping_new-post" class="custom-radio"></label>
													<label for="shipping_new-post">Выслать новой почтой</label>

												</div>

												<div class="form-item shipping_city input-and-select-in-one">
													<span class="title">Город</span>
													<div class="input-wrap input-required">

														<div class="glyphicon glyphicon-menu-down"></div>

														<!--<select  name="" id="">
															<option value="">qwe</option>
															<option value="">zxcv</option>
															<option value="">dfg</option>
															<option value="">cvb</option>
															<option value="">rty</option>
														</select>-->
														<input type="text" name="shipping_city" data-validation-mask="moreThen3Char" placeholder="Введите город доставки" />
														<ul>
															<li>Киев</li>
															<li>Харьков</li>
															<li>Днепропетровск</li>
															<li class="another">Ввести город...</li>
														</ul>
													</div>
												</div>

												<div class="form-item shipping_office input-and-select-in-one">
													<span class="title">Номер отделения</span>
													<div class="input-wrap input-required">

														<div class="glyphicon glyphicon-menu-down"></div>

														<input type="text" name="sipping_office" data-validation-mask="moreThen3Char" placeholder="Введите отделение" />

														<ul>
															<li>№1,Ленинградское шоссе</li>
															<li>№2,Ленинградское шоссе</li>
															<li>№3,Ленинградское шоссе</li>
															<li class="another">Ввести отделение...</li>
														</ul>

													</div>
												</div>

												<div class="for-legal-entity">

													<div class="form-item shipping_addressee-name">
														<span class="title">ФИО получателя</span>
														<div class="input-wrap input-required">
															<input type="text" name="shipping_addressee-name" data-validation-mask="moreThen3Char" placeholder="Иванов Иван Иванович" />
														</div>
													</div>

													<div class="form-item shipping_addressee-phone">
														<span class="title">Телефон получателя</span>
														<div class="input-wrap input-required">
															<input type="text" name="shipping_addressee-phone" data-validation-mask="phone" placeholder="(123) 456-78-90" />
														</div>
													</div>

													<div class="form-item shipping_addressee-pay input-required">
														<span class="title">Оплата посылки получателем</span>

														<div class="cash-pay">
															<input type="radio" id="shipping_addressee-pay_cash-pay" name="shipping_addressee-pay" value="cash-pay" class="display-none" />
															<label for="shipping_addressee-pay_cash-pay" class="custom-radio"></label>
															<label class="required-highlight" for="shipping_addressee-pay_cash-pay">Наличными</label>
														</div>

														<div class="non-cash-pay">
															<input type="radio" id="shipping_addressee-pay_non-cash-pay" name="shipping_addressee-pay" value="non-cash-pay" class="display-none" />
															<label for="shipping_addressee-pay_non-cash-pay" class="custom-radio"></label>
															<label class="required-highlight" for="shipping_addressee-pay_non-cash-pay">Безнал</label>
														</div>

													</div>

												</div>

											</div>

											<div class="payment-methods">

												<div class="item-title"><span class="info">i</span>Оплата товара</div>

												<div class="for-individual-entity input-required display-none">
													<div class="payment-methods_cod form-item">
														<input type="radio" id="shipping_payment-methods_cod" name="individual_payment-methods" value="cod" class="display-none" />
														<label for="shipping_payment-methods_cod" class="custom-radio"></label>
														<label for="shipping_payment-methods_cod" class="required-highlight">Наложеный платеж</label>
													</div>
													<div class="payment-methods_on-bank-card form-item">
														<input type="radio" id="shipping_payment-methods_on-bank-card" name="individual_payment-methods" value="on-bank-card" class="display-none" />
														<label for="shipping_payment-methods_on-bank-card" class="custom-radio"></label>
														<label for="shipping_payment-methods_on-bank-card" class="required-highlight">На карту банка</label>
													</div>
												</div>

												<div class="for-legal-entity">
													<div class="payment-methods_non-cash-payment form-item">
														<input type="radio" id="shipping_payment-methods_non-cash-payment" name="legal_payment-methods" value="non-cash-payment" checked="true" class="display-none" />
														<label for="shipping_payment-methods_non-cash-payment" class="custom-radio"></label>
														<label for="shipping_payment-methods_non-cash-payment">Безналичными</label>
													</div>
												</div>

												<div class="checkout-block">
													<div class="checkout-button green-button" >Оформить заказ</div>
													<div class="user-agreement-title">Я подтверждаю заказ и принимаю условия<br/><a href="#">пользовательского соглашения</a></div>
												</div>

											</div>

											<div class="add-comment">
												<div class="link-button add-comment-title" data-text="Скрыть коментарий к заказу">Добавить коментарий к заказу</div>
												<div class="textarea-wrap display-none"><textarea class="sdisplay-none" name="comment" id="comment" cols="60" rows="5"></textarea></div>
											</div>

										</form>

									</div>
								</div>

						</div>

					</div>

				</div>
				<?php include '../products/viewed-products.php' ?>
			</div>
			<aside class="col-sm-4 col-sm-pull-16">

				<div class="banner clarify-price">
					<div href="#" class="banner-header">
						<span class="banner-header-title">СТОИМОСТЬ ОБОРУДОВАНИЯ</span>
					</div>

					<div class="banner-content align-left">

						<span>Важно! В связи со значительным колебанием курса валюты, уточняйте стоимость оборудования на момент оформления заказа. Спасибо за понимание.</span>

						<div class="cart-button">Уточнить стоимость</div>

					</div>
				</div>

				<?php include '../brands/banners/supplier.php' ?>

				<div class="banner list">
					<div href="#" class="banner-header">
						<span class="banner-header-title">ТЕХПОДДЕРЖКА</span>
					</div>

					<div class="banner-content align-left">
						<a href="#">
							<div class="glyphicon glyphicon-menu-right"></div>
							<span class="text-wrap">Как выбрать индуктивный датчик</span>
						</a>
						<a href="#">
							<div class="glyphicon glyphicon-menu-right"></div>
							<span class="text-wrap">Часто задаваемые вопросы</span>
						</a>
						<a href="#">
							<div class="glyphicon glyphicon-menu-right"></div>
							<span class="text-wrap">Система метрик</span>
						</a>
						<a href="#">
							<div class="glyphicon glyphicon-menu-right"></div>
							<span class="text-wrap">Таблица размеров</span>
						</a>
					</div>
				</div>

			</aside>
		</div>
	</div>
	<?php include '../footer.php' ?>
	<?php include '../absolue-elements.php' ?>
</body>
</html>