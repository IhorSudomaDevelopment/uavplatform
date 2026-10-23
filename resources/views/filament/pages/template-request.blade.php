
<x-filament-panels::page>
    <div class="fr-page">
        <div class="fr-heading">
            <div>
                <h1>Заявка на політ</h1>
                <p>Заповни дані та сформуй готовий текст заявки.</p>
            </div>
            <span class="fr-status">
                <span></span> Генератор заявки
            </span>
        </div>

        <div class="fr-layout">
            <section class="fr-card">
                <div class="fr-card-heading">
                    <div class="fr-icon">✎</div>
                    <div>
                        <h2>Дані заявки</h2>
                        <p>Параметри для формування тексту</p>
                    </div>
                </div>

                <div class="fr-fields">
                    <label class="fr-field">
                        <span>Дата</span>
                        <input id="date" type="date"
                               value="{{ now('Europe/Kyiv')->format('Y-m-d') }}">
                    </label>

                    <label class="fr-field">
                        <span>Підрозділ</span>
                        <input id="unit" value="ББпС 82 ОДШБр">
                    </label>

                    <label class="fr-field">
                        <span>Позивний</span>
                        <input id="callsign" value="Фахівці">
                    </label>

                    <label class="fr-field fr-wide">
                        <span>Екіпаж</span>
                        <textarea id="crew" rows="3">Люцифер, Айтішнік, Баджо, Міф, Давид</textarea>
                    </label>

                    <label class="fr-field">
                        <span>Тип БпЛА</span>
                        <select id="drone">
                            <option>Heavy Shot</option>
                            <option>Heavy Shot Жвавий</option>
                            <option>Nemesis</option>
                            <option>Nemesis K</option>
                            <option>Nemesis XS</option>
                            <option>Perun</option>
                            <option>Vampire</option>
                            <option>SHTURM</option>
                        </select>
                    </label>

                    <label class="fr-field">
                        <span>Час початку</span>
                        <input id="start" type="time" value="01:10">
                    </label>

                    <label class="fr-field">
                        <span>Час завершення</span>
                        <input id="end" type="time" value="01:50">
                    </label>

                    <label class="fr-field fr-wide">
                        <span>Призначення</span>
                        <select id="purpose">
                            <option>Доставка</option>
                            <option>Евакуаційна місія</option>
                            <option>Засідка</option>
                            <option>Логістична місія</option>
                            <option>Мінування</option>
                            <option>Перегін борта</option>
                            <option>Пожежогасіння</option>
                            <option selected>Ураження</option>
                        </select>
                    </label>

                    <label class="fr-field fr-wide">
                        <span>Маршрут</span>
                        <input id="route" value="околиці Новоолександрівки - ЛБЗ">
                    </label>

                    <label class="fr-field">
                        <span>Висота</span>
                        <input id="altitude" value="90 - 160">
                    </label>

                    <label class="fr-field fr-wide">
                        <span>Додаткова інформація</span>
                        <textarea id="frequencies" rows="3"></textarea>
                    </label>
                </div>

                <p class="fr-hint">Зміни будь-яке поле — текст оновиться автоматично.</p>
            </section>

            <section class="fr-card fr-output-card">
                <div class="fr-card-heading">
                    <div class="fr-icon fr-icon-output">☷</div>
                    <div>
                        <h2>Готовий текст</h2>
                        <p>Результат для копіювання</p>
                    </div>
                </div>

                <textarea id="result" class="fr-result" readonly
                          aria-label="Готовий текст заявки"></textarea>

                <div class="fr-actions">
                    <button id="copyBtn" type="button" class="fr-btn fr-primary">
                        <span>▣</span> Копіювати текст
                    </button>
                    <button id="selectBtn" type="button" class="fr-btn fr-secondary">
                        Виділити текст
                    </button>
                </div>

                <p id="status" class="fr-status-message" role="status"></p>
            </section>
        </div>
    </div>

    <style>
        .fr-page {
            --fr-accent: #06b6d4;
            --fr-border: #374151;
            --fr-muted: #9ca3af;
            color: var(--gray-950, #f9fafb);
        }

        .fr-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin: 0 0 24px;
        }

        .fr-heading h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 750;
            letter-spacing: -.6px;
        }

        .fr-heading p,
        .fr-card-heading p {
            margin: 5px 0 0;
            color: var(--fr-muted);
            font-size: 13px;
        }

        .fr-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--fr-muted);
            font-size: 12px;
            white-space: nowrap;
        }

        .fr-status > span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
        }

        .fr-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(320px, .9fr);
            gap: 22px;
            align-items: start;
        }

        .fr-card {
            min-width: 0;
            padding: 24px;
            border: 1px solid var(--fr-border);
            border-radius: 16px;
            background: var(--fi-section-bg, #111318);
            box-shadow: 0 8px 28px rgb(0 0 0 / 10%);
        }

        .fr-card-heading {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 24px;
        }

        .fr-icon {
            display: grid;
            place-items: center;
            flex: 0 0 44px;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            color: #22d3ee;
            background: rgb(6 182 212 / 12%);
            font-size: 24px;
        }

        .fr-icon-output {
            color: #a5b4fc;
            background: rgb(129 140 248 / 13%);
        }

        .fr-card-heading h2 {
            margin: 0;
            font-size: 17px;
            font-weight: 700;
        }

        .fr-fields {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 19px 14px;
        }

        .fr-field {
            display: flex;
            flex-direction: column;
            gap: 7px;
            min-width: 0;
            font-size: 13px;
            font-weight: 600;
        }

        .fr-wide {
            grid-column: 1 / -1;
        }

        .fr-field input,
        .fr-field select,
        .fr-field textarea {
            display: block;
            width: 100%;
            min-width: 0;
            min-height: 42px;
            padding: 10px 12px;
            border: 1px solid #4b5563;
            border-radius: 9px;
            background: #0b0d12;
            color: #f9fafb;
            font: inherit;
            font-weight: 400;
            font-size: 14px;
            box-shadow: none;
        }

        .fr-field textarea {
            resize: vertical;
            min-height: 76px;
        }

        .fr-field input:focus,
        .fr-field select:focus,
        .fr-field textarea:focus,
        .fr-result:focus {
            outline: 2px solid rgb(6 182 212 / 35%);
            border-color: var(--fr-accent);
        }

        .fr-hint {
            margin: 20px 0 0;
            color: var(--fr-muted);
            font-size: 12px;
        }

        .fr-result {
            display: block;
            width: 100%;
            min-height: 410px;
            padding: 17px;
            border: 1px solid var(--fr-border);
            border-radius: 11px;
            background: #0b0d12;
            color: #e5e7eb;
            font-family: ui-monospace, SFMono-Regular, Consolas, monospace;
            font-size: 13px;
            line-height: 1.8;
            white-space: pre-wrap;
            resize: vertical;
        }

        .fr-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 16px;
        }

        .fr-btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 9px;
            min-height: 43px;
            padding: 11px 15px;
            border: 1px solid transparent;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 650;
            cursor: pointer;
            transition: filter .15s, transform .15s;
        }

        .fr-btn:hover {
            filter: brightness(1.1);
        }

        .fr-btn:active {
            transform: scale(.98);
        }

        .fr-primary {
            background: #0891b2;
            color: white;
        }

        .fr-secondary {
            border-color: #4b5563;
            background: #252a34;
            color: #e5e7eb;
        }

        .fr-status-message {
            min-height: 20px;
            margin: 12px 0 0;
            color: #4ade80;
            font-size: 12px;
        }

        @media (max-width: 1100px) {
            .fr-layout {
                grid-template-columns: 1fr;
            }

            .fr-result {
                min-height: 280px;
            }
        }

        @media (max-width: 650px) {
            .fr-card {
                padding: 17px;
            }

            .fr-fields {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .fr-heading {
                align-items: flex-start;
            }

            .fr-heading h1 {
                font-size: 23px;
            }

            .fr-status {
                display: none;
            }
        }

        @media (max-width: 420px) {
            .fr-fields {
                grid-template-columns: 1fr;
            }

            .fr-wide {
                grid-column: auto;
            }

            .fr-actions {
                flex-direction: column;
            }

            .fr-btn {
                width: 100%;
            }
        }


        /* Компактне розташування форми на одному екрані */
        .fi-main {
            padding-top: 12px !important;
            padding-bottom: 8px !important;
        }

        .fr-heading {
            margin-bottom: 12px !important;
        }

        .fr-heading h1 {
            font-size: 23px !important;
        }

        .fr-card {
            padding: 16px !important;
            border-radius: 12px !important;
        }

        .fr-card-heading {
            margin-bottom: 14px !important;
            gap: 10px !important;
        }

        .fr-icon {
            width: 36px !important;
            height: 36px !important;
            flex-basis: 36px !important;
            font-size: 20px !important;
        }

        .fr-fields {
            gap: 10px 12px !important;
        }

        .fr-field {
            gap: 4px !important;
            font-size: 12px !important;
        }

        .fr-field input,
        .fr-field select {
            min-height: 35px !important;
            padding: 6px 9px !important;
            font-size: 12px !important;
        }

        .fr-field textarea {
            min-height: 48px !important;
            padding: 6px 9px !important;
            font-size: 12px !important;
        }

        .fr-hint {
            margin-top: 10px !important;
        }

        .fr-result {
            min-height: 0 !important;
            height: clamp(220px, calc(100vh - 390px), 430px);
            padding: 12px !important;
            font-size: 12px !important;
            line-height: 1.55 !important;
        }

        .fr-actions {
            gap: 8px !important;
            margin-top: 10px !important;
        }

        .fr-btn {
            min-height: 36px !important;
            padding: 8px 12px !important;
            font-size: 12px !important;
        }

        .fr-status-message {
            min-height: 14px !important;
            margin-top: 6px !important;
        }

        @media (min-width: 1101px) {
            .fr-layout {
                grid-template-columns: minmax(0, 1.35fr) minmax(320px, .9fr);
                gap: 16px !important;
            }
        }

        @media (max-height: 850px) and (min-width: 1101px) {
            .fr-card {
                padding: 12px !important;
            }

            .fr-card-heading {
                margin-bottom: 9px !important;
            }

            .fr-fields {
                gap: 7px 10px !important;
            }

            .fr-hint {
                margin-top: 6px !important;
            }

            .fr-result {
                height: calc(100vh - 340px);
            }
        }
    </style>

    <script>
        (() => {
            function initFlightRequest() {
                const root = document.querySelector('.fr-page');
                if (!root || root.dataset.initialized) return;
                root.dataset.initialized = 'true';

                const $ = id => root.querySelector('#' + id);
                const ids = [
                    'date', 'unit', 'callsign', 'crew', 'drone',
                    'start', 'end', 'purpose', 'route',
                    'altitude', 'frequencies'
                ];

                $('frequencies').value =
                    '10.7 - 14.5 ГГц - Starlink\n1200 - 1400 МГц - Супутники';

                function generateText() {
                    const date = $('date').value;
                    const formattedDate = date
                        ? date.split('-').reverse().join('.')
                        : '';

                    $('result').value = [
                        'Заявка на політ:',
                        `Дата: ${formattedDate}`,
                        `Підрозділ: ${$('unit').value.trim()}`,
                        `Позивний: "${$('callsign').value.trim()}"`,
                        `Екіпаж: ${$('crew').value.trim()}`,
                        `Тип БпЛА: "${$('drone').value}"`,
                        `Час: ${$('start').value} - ${$('end').value}`,
                        `Призначення: ${$('purpose').value}`,
                        `Маршрут: ${$('route').value.trim()}`,
                        `Висота: ${$('altitude').value.trim()}`,
                        'Частоти:',
                        $('frequencies').value.trim()
                    ].join('\n');
                }

                ids.forEach(id => {
                    $(id).addEventListener('input', generateText);
                    $(id).addEventListener('change', generateText);
                });

                $('copyBtn').addEventListener('click', async () => {
                    try {
                        await navigator.clipboard.writeText($('result').value);
                        $('status').textContent = 'Текст скопійовано.';
                    } catch {
                        $('result').focus();
                        $('result').select();
                        $('status').textContent =
                            'Натисни Ctrl+C, щоб скопіювати текст.';
                    }
                });

                $('selectBtn').addEventListener('click', () => {
                    $('result').focus();
                    $('result').select();
                    $('status').textContent =
                        'Текст виділено. Натисни Ctrl+C.';
                });

                generateText();
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initFlightRequest);
            } else {
                initFlightRequest();
            }

            document.addEventListener('livewire:navigated', initFlightRequest);
        })();
    </script>
</x-filament-panels::page>


<script>
    document.addEventListener('livewire:navigated', initFlightRequest);

    function initFlightRequest() {
        const $ = (id) => document.getElementById(id);
        const result = $('result');

        if (!result || result.dataset.initialized) return;

        result.dataset.initialized = 'true';

        function generateText() {
            const date = $('date').value;
            const formattedDate = date
                ? date.split('-').reverse().join('.')
                : '';

            result.value = [
                'Заявка:',
                `Дата: ${formattedDate}`,
                `Підрозділ: ${$('unit').value.trim()}`,
                `Позивний: ${$('callsign').value.trim()}`,
                `Склад екіпажу: ${$('crew').value.trim()}`
            ].join('\n');
        }

        ['date', 'unit', 'callsign', 'crew'].forEach(id => {
            $(id).addEventListener('input', generateText);
            $(id).addEventListener('change', generateText);
        });

        $('copyBtn').addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(result.value);
                $('status').textContent = 'Текст скопійовано.';
            } catch {
                result.focus();
                result.select();
                $('status').textContent =
                    'Виділи текст і натисни Ctrl+C.';
            }
        });

        $('selectBtn').addEventListener('click', () => {
            result.focus();
            result.select();
            $('status').textContent =
                'Текст виділено. Натисни Ctrl+C.';
        });

        generateText();
    }

    initFlightRequest();
</script>
