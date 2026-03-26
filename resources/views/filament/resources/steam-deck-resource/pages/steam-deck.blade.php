<x-filament::page>
	<div class="flex flex-col gap-4">
		<div class="flex justify-center text-2xl">ПУЛЬТ</div>
		<div class="flex flex-col gap-4">
			<table class="table-auto border-collapse">
				<tbody>
				<tr>
					<td class="border p-2">
						<img src="{{ asset('images/left-key.png') }}" alt="">
					</td>
					<td class="border p-2">Стрілка ліворуч</td>
					<td class="border p-2">Зміна камери - денна/нічна</td>
				</tr>
				<tr>
					<td class="border p-2">
						<img src="{{ asset('images/right-key.png') }}" alt="">
					</td>
					<td class="border p-2">Стрілка праворуч</td>
					<td class="border p-2">Зміна контрасту камери</td>
				</tr>
				<tr>
					<td class="border p-2">
						<img src="{{ asset('images/top-bottom-key.png') }}" alt="">
					</td>
					<td class="border p-2">Стрілки вверх-вниз</td>
					<td class="border p-2">Зміна положення камери</td>
				</tr>
				<tr>
					<td class="border p-2">
						<img src="{{ asset('images/x-key.png') }}" alt="">
					</td>
					<td class="border p-2">Кнопка Х</td>
					<td class="border p-2">Режим</td>
				</tr>
				<tr>
					<td class="border p-2">
						<img src="{{ asset('images/y-key.png') }}" alt="">
					</td>
					<td class="border p-2">Кнопка Y</td>
					<td class="border p-2">Режим</td>
				</tr>
				<tr>
					<td class="border p-2">
						<img src="{{ asset('images/b-key.png') }}" alt="">
					</td>
					<td class="border p-2">Кнопка B</td>
					<td class="border p-2">Режим</td>
				</tr>
				<tr>
					<td class="border p-2">
						<img src="{{ asset('images/a-key.png') }}" alt="">
					</td>
					<td class="border p-2">Кнопка A</td>
					<td class="border p-2">Режим</td>
				</tr>

				<tr>
					<td class="border p-2">
						<img src="{{ asset('images/a-key.png') }}" alt="">
					</td>
					<td class="border p-2">Лівий стік</td>
					<td class="border p-2">Yaw, Throttle</td>
				</tr>
				<tr>
					<td class="border p-2">
						<img src="{{ asset('images/a-key.png') }}" alt="">
					</td>
					<td class="border p-2">Правий стік</td>
					<td class="border p-2">Pitch, Roll</td>
				</tr>
				</tbody>
			</table>
			<div class="flex ">
				<img src="{{ asset('images/steam-deck-config-main.png') }}" alt="">
			</div>
			<div class="flex ">
				<img src="{{ asset('images/steam-deck-config-top.png') }}" alt="">
			</div>
		</div>
	</div>

	<div class="flex flex-col gap-4">
		<div class="flex justify-center text-2xl">ОРГАНІЗАЦІЯ ПІДКЛЮЧЕННЯ ПУЛЬТ-НАЗЕМНА СТАНЦІЯ - АНТЕНА</div>
		<div class="flex flex-col gap-4">
			<div>
				1. Під’єднуємо пульт до наземної станції (Type C роз’єм)
			</div>
			<div class="flex ">
				<img src="{{ asset('images/set-station-1.png') }}" alt="">
			</div>
			<div>
				2. Під’єднуємо антету до наземної станції (Ethernet)
			</div>
			<div class="flex ">
				<img src="{{ asset('images/set-station-2.png') }}" alt="">
			</div>
			<div class="flex ">
				<img src="{{ asset('images/set-station-3.png') }}" alt="">
			</div>
			<div>
				3. Вмикаємо кнопку Batt volt для контролю
			</div>
			<div class="flex ">
				<img src="{{ asset('images/set-station-4.png') }}" alt="">
			</div>
			<div>
				4. Вмикаємо пульт
			</div>
			<div>
				5. Пароль для пульта: 1111
			</div>
			<div style="color: red">
				Примітка: Під’єднуємо ethernet-кабель від наземної станції до антени. Лише після цього ввмикаємо живлення
			</div>
			<div class="flex ">
				<img src="{{ asset('images/set-station-5.png') }}" alt="">
			</div>
		</div>
	</div>

	<div class="flex flex-col gap-4">
		<div class="flex justify-center text-2xl">BIND (PAIR) З БОРТОМ</div>
		<div class="flex flex-col gap-4">
			<div>
				1. Перейти по кнопці як показано на зображені, після сигналу та мигання індикатора на борті (як і раніше з Herelink), натиснути “bind”
			</div>
			<div class="flex ">
				<img src="{{ asset('images/bind-1.png') }}" alt="">
			</div>
			<div>
				2. Після чого буде наступне меню:
			</div>
			<div class="flex ">
				<img src="{{ asset('images/bind-2.png') }}" alt="">
			</div>
		</div>
	</div>
</x-filament::page>
