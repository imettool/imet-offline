/*
 * Copyright (C) 2025 European Union
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by the Free Software Foundation,
 * either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

import Base from "@modular-forms/js/apps/Base.js";
import {ref} from "vue";

export default class HotKeysApp extends Base {

    constructor() {

        const options = {

            name: 'HotKeysApp',

            setup(props, context){

                let zoom = ref(100);

                if(Object.keys(window.Native).length>0) {

                    window.Native.on("App\\Events\\ZoomInHotKeyPressed", (payload, event) => {
                        zoom.value += 10;
                        document.querySelector('body').style.zoom = zoom.value + '%';
                    });
                    window.Native.on("App\\Events\\ZoomOutHotKeyPressed", (payload, event) => {
                        zoom.value -= 10;
                        document.querySelector('body').style.zoom = zoom.value + '%';
                    });
                    window.Native.on("App\\Events\\ZoomResetHotKeyPressed", (payload, event) => {
                        zoom.value = 100;
                        document.querySelector('body').style.zoom = zoom.value + '%';
                    });


                }

                return {};
            }
        }

        return super(options, {});
    }

}
