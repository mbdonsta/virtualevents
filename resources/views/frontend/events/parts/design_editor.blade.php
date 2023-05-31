<button class="open-editor">
    <svg version="1.1" id="SETTINGS" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
         viewBox="0 0 1800 1800" enable-background="new 0 0 1800 1800"
         xml:space="preserve">
<g>
    <path fill="#333333" d="M1468.436,32.467v188.211c-98.748,15.249-174.595,100.822-174.595,203.777s75.847,188.521,174.595,203.777
		v1139.302c0,17.453,14.146,31.608,31.607,31.608c17.454,0,31.609-14.155,31.609-31.608V628.232
		c98.748-15.257,174.59-100.822,174.59-203.777s-75.842-188.529-174.59-203.777V32.467c0-17.454-14.155-31.608-31.609-31.608
		C1482.581,0.858,1468.436,15.013,1468.436,32.467z M1643.029,424.455c0,67.979-47.703,124.986-111.377,139.423
		c-10.179,2.302-20.744,3.563-31.609,3.563s-21.43-1.261-31.607-3.563c-63.684-14.438-111.378-71.444-111.378-139.423
		c0-67.988,47.694-124.995,111.378-139.424c10.178-2.311,20.742-3.563,31.607-3.563s21.431,1.252,31.609,3.563
		C1595.326,299.46,1643.029,356.467,1643.029,424.455z"/>
    <path fill="#333333" d="M331.574,1767.534V628.232c98.758-15.257,174.603-100.822,174.603-203.777s-75.845-188.529-174.603-203.777
		V32.467c0-17.454-14.146-31.608-31.608-31.608c-17.454,0-31.608,14.155-31.608,31.608v188.211
		C169.609,235.926,93.763,321.5,93.763,424.455s75.846,188.521,174.594,203.777v1139.302c0,17.453,14.155,31.608,31.608,31.608
		C317.428,1799.143,331.574,1784.987,331.574,1767.534z M156.98,424.455c0-67.988,47.703-124.995,111.377-139.424
		c10.178-2.311,20.752-3.563,31.608-3.563c10.865,0,21.431,1.252,31.608,3.563c63.684,14.429,111.387,71.436,111.387,139.424
		c0,67.979-47.703,124.986-111.387,139.423c-10.178,2.302-20.743,3.563-31.608,3.563c-10.856,0-21.431-1.261-31.608-3.563
		C204.683,549.441,156.98,492.434,156.98,424.455z"/>
    <path fill="#333333" d="M931.617,1767.534V1419.51c98.748-15.257,174.594-100.822,174.594-203.777s-75.846-188.529-174.594-203.777
		V32.467c0-17.454-14.154-31.608-31.608-31.608c-17.462,0-31.608,14.155-31.608,31.608v979.488
		c-98.757,15.248-174.603,100.822-174.603,203.777s75.846,188.521,174.603,203.777v348.024c0,17.453,14.146,31.608,31.608,31.608
		C917.463,1799.143,931.617,1784.987,931.617,1767.534z M757.015,1215.732c0-67.986,47.703-124.995,111.386-139.424
		c10.177-2.309,20.743-3.563,31.608-3.563c10.865,0,21.431,1.254,31.608,3.563c63.676,14.429,111.378,71.438,111.378,139.424
		c0,67.979-47.702,124.986-111.378,139.424c-10.178,2.303-20.743,3.563-31.608,3.563c-10.865,0-21.431-1.26-31.608-3.563
		C804.717,1340.719,757.015,1283.711,757.015,1215.732z"/>
</g>
</svg>
</button>
<div id="designEditor">

    <div class="editor-box">
        <div class="wrapper">
            <a href="#" class="close"></a>
            <form id="designSettings" action="{{ route('backend.events.design_update', ['event' => $event->id]) }}"
                  method="POST">
                @include('global.notices')
                @csrf
                @method('PATCH')
                <div class="setting-section event-title">
                    <h4 class="mb-3">{{ __('Event title settings') }}</h4>
                    <div>
                        <label>{{ __('Title font size') }}</label>
                        <div class="input-group mb-5">
                            <input type="number" class="form-control" name="settings[title_fontsize]" min="20" max="400"
                                   step="1"
                                   value="{{ $settings['title_fontsize'] }}"/>
                            <span class="input-group-text">px</span>
                        </div>

                    </div>
                    <div>
                        <label>{{ __('Title logo size') }}</label>
                        <div class="input-group mb-5">
                            <input type="number" class="form-control" name="settings[title_logo_size]" min="20"
                                   max="400"
                                   step="1"
                                   value="{{ $settings['title_logo_size'] }}"/>
                            <span class="input-group-text">px</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Title color') }}</label>
                        <input type="color" class="form-control" name="settings[title_color]"
                               value="{{ $settings['title_color'] }}"/>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Title effect') }}</label>
                        <select class="form-select py-1" name="settings[title_effect]">
                            <option value="">{{ __('None') }}</option>
                            <option
                                value="1" {{ (int) $settings['title_effect'] === 1 ? 'selected' : '' }}>{{ __('Text shadow') }}</option>
                        </select>
                    </div>
                    <div class="mb-4 shadow-color"
                         style="display: {{ (int) $settings['title_effect'] === 1 ? 'block' : 'none' }};">
                        <label>{{ __('Shadow color') }}</label>
                        <input type="color" class="form-control" name="settings[title_shadow_color]"
                               value="{{ $settings['title_shadow_color'] }}"/>
                    </div>
                </div>
                <div class="setting-section event-bg">
                    <h4 class="mb-3">{{ __('Background settings') }}</h4>
                    <div class="mb-4">
                        <label>{{ __('Background color') }}</label>
                        <input type="color" class="form-control" name="settings[bg_color]"
                               value="{{ $settings['bg_color'] }}"/>
                    </div>
                </div>
                <div class="setting-section event-bg">
                    <h4 class="mb-3">{{ __('Program settings') }}</h4>
                    <div class="mb-4">
                        <label>{{ __('Show days filter') }}</label>
                        <select class="form-select" name="settings[show_days]">
                            <option value="0">{{ __('No') }}</option>
                            <option
                                value="1" {{ $settings['show_days'] == 1 ? 'selected' : '' }}>{{ __('Yes') }}</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Show rooms filter') }}</label>
                        <select class="form-select" name="settings[show_rooms]">
                            <option value="0">{{ __('No') }}</option>
                            <option
                                value="1" {{ $settings['show_rooms'] == 1 ? 'selected' : '' }}>{{ __('Yes') }}</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Day filter button background') }}</label>
                        <input type="color" class="form-control" name="settings[day_button_bg]"
                               value="{{ $settings['day_button_bg'] }}"/>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Day filter button text') }}</label>
                        <input type="color" class="form-control" name="settings[day_button_text]"
                               value="{{ $settings['day_button_text'] }}"/>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Room filter button background') }}</label>
                        <input type="color" class="form-control" name="settings[room_button_bg]"
                               value="{{ $settings['room_button_bg'] }}"/>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Room filter button text') }}</label>
                        <input type="color" class="form-control" name="settings[room_button_text]"
                               value="{{ $settings['room_button_text'] }}"/>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Time column background (EVEN)') }}</label>
                        <input type="color" class="form-control" name="settings[time_col_bg_even]"
                               value="{{ $settings['time_col_bg_even'] }}"/>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Time column text (EVEN)') }}</label>
                        <input type="color" class="form-control" name="settings[time_col_text_even]"
                               value="{{ $settings['time_col_text_even'] }}"/>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Time column background (ODD)') }}</label>
                        <input type="color" class="form-control" name="settings[time_col_bg_odd]"
                               value="{{ $settings['time_col_bg_odd'] }}"/>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Time column text (ODD)') }}</label>
                        <input type="color" class="form-control" name="settings[time_col_text_odd]"
                               value="{{ $settings['time_col_text_odd'] }}"/>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Border style') }}</label>
                        <select class="form-select" name="settings[border_style]">
                            <option value="dotted" {{ $settings['border_style'] == 'dotted' ? 'selected' : '' }}>
                                {{ __('Dotted') }}
                            </option>
                            <option value="solid" {{ $settings['border_style'] == 'solid' ? 'selected' : '' }}>
                                {{ __('Solid') }}
                            </option>
                            <option value="dashed" {{ $settings['border_style'] == 'dashed' ? 'selected' : '' }}>
                                {{ __('Dashed') }}
                            </option>
                            <option value="double" {{ $settings['border_style'] == 'double' ? 'selected' : '' }}>
                                {{ __('Double') }}
                            </option>
                            <option value="groove" {{ $settings['border_style'] == 'groove' ? 'selected' : '' }}>
                                {{ __('Groove') }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Border color') }}</label>
                        <input type="color" class="form-control" name="settings[border_color]"
                               value="{{ $settings['border_color'] }}"/>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Item title color') }}</label>
                        <input type="color" class="form-control" name="settings[item_title]"
                               value="{{ $settings['item_title'] }}"/>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Item subtitle color') }}</label>
                        <input type="color" class="form-control" name="settings[item_subtitle]"
                               value="{{ $settings['item_subtitle'] }}"/>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Item button background') }}</label>
                        <input type="color" class="form-control" name="settings[item_button_bg]"
                               value="{{ $settings['item_button_bg'] }}"/>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Item button text') }}</label>
                        <input type="color" class="form-control" name="settings[item_button_text]"
                               value="{{ $settings['item_button_text'] }}"/>
                    </div>
                </div>
                <div class="setting-section event-bg">
                    <h4 class="mb-3">{{ __('Navigation settings') }}</h4>
                    <div class="mb-4">
                        <label>{{ __('Background color') }}</label>
                        <input type="color" class="form-control" name="settings[nav_bg_color]"
                               value="{{ $settings['nav_bg_color'] }}"/>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Buttons color') }}</label>
                        <input type="color" class="form-control" name="settings[nav_buttons_color]"
                               value="{{ $settings['nav_buttons_color'] }}"/>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Buttons border color') }}</label>
                        <input type="color" class="form-control" name="settings[nav_buttons_border_color]"
                               value="{{ $settings['nav_buttons_border_color'] }}"/>
                    </div>
                </div>
                <div class="submit-box">
                    <button type="submit" class="btn btn-sm btn-primary">{{ __('Save settings') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
