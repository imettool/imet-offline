<?php
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
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

return [

    'setup' => 'Configuração',
    'please_follow_instructions' => 'Por favor, siga as instruções abaixo',
    'next' => 'Próximo',
    'citation' => 'Citação',

    'timeline' => [

    ],

    'info' => [
        'timeline' => 'Iniciar configuração',
        'description' => 'Bem-vindo à <b>Ferramenta IMET offline</b>!<br> Esta é a primeira vez que utiliza a aplicação
                e é necessário um rápido processo de configuração para começar.',
        'offline_warning' => 'A Ferramenta IMET offline foi concebida para ser usada em campo, onde a conectividade à
                Internet pode ser limitada ou indisponível, mas durante este processo de configuração <b>é necessária uma
                ligação à Internet</b>. Por favor, assegure-se de que está ligado à Internet antes de prosseguir.',
    ],

    'user' => [
        'timeline' => 'Informações pessoais',
        'info' => '<div>As informações fornecidas permanecerão privadas e armazenadas localmente. No entanto, as informações
                    serão associadas a quaisquer avaliações criadas ou modificadas com este software; exportar e partilhar
                    a avaliação implica, portanto, partilhar também as informações.</div>',
    ],

    'species' => [
        'timeline' => 'Espécies',
        'info' => '<div>Esta etapa é necessária para integrar os dados de espécies recuperados do <b>Catalogue of Life</b>
                    na aplicação. O conjunto de dados é necessário para identificar precisamente as espécies durante as
                    avaliações.</div><div>O conjunto de dados recuperado inclui todas as espécies animais e vegetais.
                    Vermes, ácaros, insetos e outros microrganismos estão excluídos de momento. O conjunto de dados contém
                    a taxonomia completa e os nomes comuns (em várias línguas).</div>',
        'citation' => 'Bánki, O., Roskov, Y., Döring, M., Ower, G., Hernández Robles, D. R., Plata Corredor, C. A.,
                    Stjernegaard Jeppesen, T., Örn, A., Pape, T., Hobern, D., Garnett, S., Little, H., DeWalt, R. E., Miller,
                    J., Orrell, T., Aalbu, R., Abbott, J., Aedo, C., Aescht, E., et al. (2025). <b>Catalogue of Life </b>
                    (Version 2025-09-11). Catalogue of Life Foundation, Amsterdam, Netherlands.
                    <a target="_blank" href="https://doi.org/10.48580/dgt98">https://doi.org/10.48580/dgt98</a>',
        'instructions' => 'Para integrar os dados de espécies na aplicação, clique no botão a seguir. Este processo pode
                            demorar alguns minutos, dependendo do desempenho do seu dispositivo. Por favor, seja paciente
                            e não feche a aplicação.'
    ],

    'wdpas' => [
        'timeline' => 'Áreas protegidas e OECMs',
        'info' => 'Esta etapa é necessária para integrar <b>o Banco de Dados Mundial de Áreas Protegidas (WDPA)</b> e <b>
                    o Banco de Dados Mundial sobre Outras Medidas de Conservação Efetivas baseadas em Áreas (WD-OECM)</b>
                    na aplicação. Os conjuntos de dados são necessários para criar novas avaliações e associá-las à Área
                    Protegida ou OECM correta.',
        'warning' => 'Observe que o processo requer uma ligação à Internet.',
        'citation' => 'UNEP-WCMC and IUCN (2025), Protected Planet: The World Database on Protected Areas (WDPA) and World
                    Database on Other Effective Area-based Conservation Measures (WD-OECM) [Online], August 2025, Cambridge,
                    UK: UNEP-WCMC and IUCN. Available at:
                    <a target="_blank" href="https://protectedplanet.net/">www.protectedplanet.net.</a>',
        'instructions' => [
            'browse' => 'Aceda ao site <span class="highlight">Protected Planet</span>
                        (<span class="highlight">www.protectedplanet.net</span>)',
            'navigate' => 'Clique no botão <span class="highlight">Explore protected areas and OECMs</span>',
            'download' => 'Localize o botão <span class="highlight mr-0.5">Download</span> e proceda ao download do
                        ficheiro <span class="highlight mr-0.5">CSV</span>.<br />Será transferido um arquivo compactado
                        <span class="highlight mr-0.5">ZIP</span>: <b>não é necessário</b> descompactá-lo.',
            'upload' => 'Clique no seguinte botão <span class="highlight mr-0.5">Upload file</span> e selecione o
                            ficheiro <span class="highlight mr-0.5">ZIP</span> transferido',
            'apply' => 'Inicie a integração do conjunto de dados na aplicação clicando no botão seguinte.',
            'completed' => 'O conjunto de dados está armazenado na aplicação.',
            'update' => 'Se quiser atualizar o conjunto de dados no futuro, pode repetir o mesmo procedimento a qualquer
                        momento a partir da página de <span class="highlight">Configurações</span>.',
            'next' => 'Agora pode prosseguir para o próximo passo.'
        ]
    ],

    'done' => [
        'timeline' => 'Configuração concluída!',
        'description' =>
            'A configuração está concluída. Agora pode começar a usar a aplicação.',
    ],




];
