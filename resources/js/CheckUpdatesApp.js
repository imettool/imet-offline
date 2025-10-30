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

export default class CheckUpdatesApp extends Base {

    constructor(input_data) {

        const options = {

            name: 'CheckUpdatesApp',

            setup(props, context){

                const STATUSES = {
                    IDLE: 'idle',
                    CHECKING: 'checking',
                    NOT_AVAILABLE: 'not_available',
                    AVAILABLE: 'available',
                    DOWNLOADING: 'downloading',
                    DOWNLOADED: 'downloaded',
                    ERROR: 'error'
                };

                let status = ref('idle');
                let downloadProgress = ref(0);
                let errorMessage = ref('');
                let newVersion = ref('');


                if(Object.keys(window.Native).length>0) {

                    window.Native.on("Native\\Desktop\\Events\\Windows\\WindowShown", (payload, event) => {
                        status.value = STATUSES.CHECKING
                        setTimeout(function () {
                            status.value = STATUSES.IDLE
                        }, 5000);
                    });

                    window.Native.on("Native\\Desktop\\Events\\AutoUpdater\\CheckingForUpdate", (payload, event) => {
                        status.value = STATUSES.CHECKING
                    });
                    window.Native.on("Native\\Desktop\\Events\\AutoUpdater\\UpdateNotAvailable", (payload, event) => {
                        status.value = STATUSES.NOT_AVAILABLE
                        setTimeout(function () {
                            status.value = STATUSES.IDLE
                        }, 20000);
                    });
                    window.Native.on("Native\\Desktop\\Events\\AutoUpdater\\UpdateAvailable", (payload, event) => {
                        status.value = STATUSES.AVAILABLE
                        newVersion.value = payload.version;
                    });
                    window.Native.on("Native\\Desktop\\Events\\AutoUpdater\\DownloadProgress", (payload, event) => {
                        status.value = STATUSES.DOWNLOADING
                        downloadProgress.value = Math.floor(payload.percent);
                    });
                    window.Native.on("Native\\Desktop\\Events\\AutoUpdater\\UpdateDownloaded", (payload, event) => {
                        status.value = STATUSES.DOWNLOADED
                    });
                    window.Native.on("Native\\Desktop\\Events\\AutoUpdater\\Error", (payload, event) => {
                        status.value = STATUSES.ERROR
                        errorMessage.value = payload.message;
                    });

                }

                return {
                    STATUSES,
                    status,
                    downloadProgress,
                    errorMessage,
                    newVersion
                };
            }
        }

        return super(options, input_data);
    }

}
