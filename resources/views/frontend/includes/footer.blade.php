<footer class="footer">
	<div class="footer-area">
		<div class="container">
			<div class="row section_gap">
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="single-footer-widget tp_widgets">
						<h5 class="footer_title ">Sứ Mệnh Của Chúng Tôi</h5>
						<p>
							Chúng tôi luôn nỗ lực mang đến những sản phẩm chất lượng, bền vững và uy tín cho khách hàng.
						</p>
						<p>
							Mục tiêu của chúng tôi là đồng hành cùng bạn trong suốt hành trình mua sắm và trải nghiệm dịch vụ tốt nhất.
						</p>
					</div>
				</div>
				<div class="offset-lg-1 col-lg-2 col-md-6 col-sm-6">
					<div class="single-footer-widget tp_widgets">
						<h4 class="footer_title">Liên Kết Nhanh</h4>
						<ul class="list">
							<li><a href="#">Trang chủ</a></li>
							<li><a href="#">Cửa hàng</a></li>
							<li><a href="#">Blog</a></li>
							<li><a href="#">Sản phẩm</a></li>
							<li><a href="#">Thương hiệu</a></li>
							<li><a href="#">Liên hệ</a></li>
						</ul>
					</div>
				</div>
				
				<div class="offset-lg-1 col-lg-3 col-md-6 col-sm-6">
					<div class="single-footer-widget tp_widgets">
						<h4 class="footer_title">Liên Hệ Với Chúng Tôi</h4>
						<div class="ml-40">
							<p class="sm-head">
								<span class="fa fa-location-arrow"></span>
								Trụ Sở Chính
							</p>
							<p>{{ $settings['shop_address']->value ?? 'Chưa có địa chỉ' }}</p>


							<p class="sm-head">
								<span class="fa fa-phone"></span>
								Số Điện Thoại
							</p>
							<p>
								{{ $settings['shop_phone']->value ?? 'Chưa có sdt' }} 
							</p>

							<p class="sm-head">
								<span class="fa fa-envelope"></span>
								Email
							</p>
							<p>
								{{ $settings['shop_email']->value ?? 'Chưa có email' }}
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="footer-bottom">
		<div class="container">
			<div class="row d-flex">
				<p class="col-lg-12 footer-text text-center">
Copyright &copy;<script>document.write(new Date().getFullYear());</script> Bản quyền thuộc về tất cả | Giao diện được thiết kế với <i class="fa fa-heart" aria-hidden="true"></i> bởi <a href="https://colorlib.com" target="_blank">Colorlib</a>
				</p>
			</div>
		</div>
	</div>
</footer>
