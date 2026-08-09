<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SupplyPro | Console d'Approvisionnement & Logistique</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
        :root {
            --bg-color: #060913;
            --panel-bg: rgba(17, 24, 43, 0.45);
            --border-color: rgba(255, 255, 255, 0.08);
            --text-main: #f1f5f9;
            --text-muted: #64748b;
            --accent: #0ea5e9; /* Cyan */
            --accent-glow: rgba(14, 165, 233, 0.15);
            --success: #10b981;
            --danger: #f43f5e;
            --warning: #f59e0b;
            --font-family: 'Plus Jakarta Sans', sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            font-family: var(--font-family);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 0;
            margin: 0;
            overflow-x: hidden;
        }

        .app-container {
            width: 100%;
            max-width: 100%;
            padding: 24px;
        }

        /* Top Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(11, 17, 32, 0.6);
            border: 1px solid var(--border-color);
            padding: 16px 24px;
            border-radius: 16px;
            margin-bottom: 32px;
            backdrop-filter: blur(10px);
        }

        .nav-logo {
            font-size: 20px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-logo span { color: var(--accent); }

        .system-status {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 12px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border-color);
            padding: 6px 12px;
            border-radius: 20px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .status-pill.online::before {
            content: '';
            width: 8px;
            height: 8px;
            background: var(--success);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--success);
        }

        /* Two Column Layout */
        .main-layout {
            display: grid;
            grid-template-columns: 460px 1fr;
            gap: 32px;
            align-items: start;
        }

        .panel-card {
            background: var(--panel-bg);
            border: 1px solid var(--border-color);
            backdrop-filter: blur(16px);
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            margin-bottom: 32px;
        }

        .panel-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 24px;
            border-left: 3px solid var(--accent);
            padding-left: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .panel-title.danger-border { border-left-color: var(--danger); }

        /* Forms Layout */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
        }

        .form-control {
            background: rgba(10, 15, 30, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 14px 18px;
            color: white;
            font-family: var(--font-family);
            outline: none;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 10px rgba(14, 165, 233, 0.1);
        }

        /* Submit Buttons */
        .btn-submit {
            background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px 24px;
            font-weight: 800;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-family: var(--font-family);
            cursor: pointer;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(14, 165, 233, 0.3);
            filter: brightness(1.1);
        }

        .btn-submit:active { transform: translateY(0); }

        .btn-submit.btn-success {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            color: #060913;
        }

        .btn-submit.btn-success:hover {
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.35);
        }

        /* Filter ribbon above tables */
        .filter-ribbon {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 12px;
        }

        .search-bar {
            flex-grow: 1;
            position: relative;
        }

        .search-input {
            width: 100%;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 10px 16px;
            color: white;
            font-family: var(--font-family);
            font-size: 13px;
            outline: none;
        }

        .filter-chips {
            display: flex;
            gap: 6px;
        }

        .chip {
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border-color);
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.3s;
        }

        .chip.active, .chip:hover {
            background: var(--accent-glow);
            color: var(--accent);
            border-color: var(--accent);
        }

        /* Tables */
        .debt-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .debt-table th {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .debt-table td {
            padding: 14px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            font-size: 13px;
        }

        /* Badges */
        .badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge.non-payee { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
        .badge.payee { background: rgba(16, 185, 129, 0.1); color: var(--success); }
        .badge.danger { background: rgba(244, 63, 94, 0.1); color: var(--danger); }

        .btn-quick-action {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-quick-action:hover {
            background: var(--accent-glow);
            border-color: var(--accent);
            color: var(--accent);
        }

        .details-drawer {
            display: none;
            background: rgba(255,255,255,0.015);
            border: 1px solid rgba(255,255,255,0.03);
            border-radius: 12px;
            padding: 16px;
            margin-top: 10px;
            animation: fadeIn 0.3s ease;
        }

        /* Order template generator panel */
        .order-draft-panel {
            background: rgba(14, 165, 233, 0.03);
            border: 1px dashed var(--accent);
            border-radius: 12px;
            padding: 16px;
            margin-top: 12px;
            font-size: 12px;
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .draft-textarea {
            width: 100%;
            background: #0b0f1a;
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 8px;
            padding: 8px;
            color: var(--text-main);
            font-family: monospace;
            font-size: 11px;
            height: 70px;
            resize: none;
            margin-bottom: 8px;
            outline: none;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
</style>
</head>
<body>

    <div class="app-container">
        
        <!-- Top Navbar -->
        <div class="navbar">
            <div class="nav-logo">
                <span>📦</span> SupplyPro Pro
                <span style="font-size: 12px; font-weight: 500; color: var(--text-muted); margin-left: 10px; border-left: 1px solid var(--border-color); padding-left: 10px;">Console d'Approvisionnement</span>
            </div>
            <div class="system-status">
                <div class="status-pill online">Dépôt Principal Active</div>
                <div class="status-pill">Bordereaux Automatisés</div>
                <a href="debt_dashboard.html" class="back-link" style="margin-left: 10px; color: var(--text-muted); text-decoration: none; font-weight: 600; font-size: 13px;">Dashboard →</a>
            </div>
        </div>

        <!-- Main Layout -->
        <div class="main-layout">
            <!-- Left Side: Inbound POS Form & Supplier creation -->
            <div>
                <!-- 700px Inbound POS Form -->
                <div class="panel-card" style="padding: 24px; border: 1px solid rgba(14, 165, 233, 0.2); background: linear-gradient(180deg, rgba(17, 24, 43, 0.5) 0%, rgba(10, 15, 30, 0.3) 100%);">
                    <div class="panel-title" style="border-left-color: var(--accent); display: flex; justify-content: space-between; align-items: center;">
                        <span>🚚 Saisie d'Approvisionnement</span>
                        <span style="font-size: 11px; font-weight: 600; color: var(--text-muted); background: rgba(255,255,255,0.03); padding: 4px 8px; border-radius: 6px;">Nouveau Lot</span>
                    </div>
                    <form id="supply-mock-form" onsubmit="event.preventDefault(); addNewDeliverySlip();">
                        
                        <div class="form-group">
                            <label for="supplier-select">Fournisseur Partenaire</label>
                            <div style="position: relative;">
                                <select id="supplier-select" class="form-control" style="width: 100%; appearance: none; padding-right: 30px;">
                                    <option value="CCS">Comptoir Céréalier Sénégalais (CCS)</option>
                                    <option value="Diop & Freres">Grossiste Alimentaire Diop & Frères</option>
                                    <option value="SODIDA">SODIDA Distributeurs Réunis</option>
                                </select>
                                <span style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: var(--text-muted); font-size: 12px;">▼</span>
                            </div>
                        </div>

                        <!-- Articles Dynamic add -->
                        <div style="border-top: 1px dashed var(--border-color); padding-top: 16px; margin-top: 16px; margin-bottom: 16px;">
                            <label style="font-size: 12px; font-weight: 700; color: var(--accent); display: block; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Sélection des Articles & Coûts d'Achat</label>
                            <div style="display: grid; grid-template-columns: 2fr 1fr auto; gap: 12px; align-items: flex-end; margin-bottom: 16px;">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label for="pos-item-select">Article</label>
                                    <select id="pos-item-select" class="form-control" style="background-color: #0b0f1a; color: white;">
                                        <option value="21000" data-name="Sac de riz 50kg">Sac de riz 50kg (Coût d'achat : 21 000 F)</option>
                                        <option value="6500" data-name="Bidon d'huile 5L">Bidon d'huile 5L (Coût d'achat : 6 500 F)</option>
                                        <option value="9500" data-name="Carton de savon">Carton de savon (Coût d'achat : 9 500 F)</option>
                                        <option value="1200" data-name="Paquet de sucre 1kg">Paquet de sucre 1kg (Coût d'achat : 1 200 F)</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label for="pos-qty">Quantité Lot</label>
                                    <input type="number" id="pos-qty" class="form-control" value="10" min="1" style="padding: 12px 10px;">
                                </div>
                                <button type="button" class="btn-submit" onclick="addToCart(event)" style="height: 46px; width: 46px; font-size: 18px; display: flex; justify-content: center; align-items: center; background: linear-gradient(135deg, var(--accent) 0%, #0369a1 100%); font-weight: bold; border-radius: 10px;">+</button>
                            </div>

                            <!-- Cart Items list table -->
                            <table class="debt-table" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th style="padding-bottom: 8px;">Produit</th>
                                        <th style="padding-bottom: 8px;">Qté Livrée</th>
                                        <th style="padding-bottom: 8px;">Coût Achat Total</th>
                                        <th style="padding-bottom: 8px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="cart-rows">
                                    <tr id="empty-cart-row">
                                        <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 16px 0; border-bottom: none;">Aucun article dans ce lot. Ajoutez des lignes.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Ecran de Facture Digital -->
                        <div style="background: linear-gradient(135deg, rgba(14, 165, 233, 0.08) 0%, rgba(30, 41, 59, 0.4) 100%); border: 1px solid rgba(14, 165, 233, 0.15); border-radius: 16px; padding: 18px; text-align: center; margin-bottom: 20px; box-shadow: inset 0 0 15px rgba(14, 165, 233, 0.08);">
                            <span style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 1px; display: block; margin-bottom: 4px;">Valorisation Globale du Lot d'Entrée</span>
                            <div style="font-size: 28px; font-weight: 900; color: #38bdf8; letter-spacing: -0.5px; font-family: monospace; text-shadow: 0 0 10px rgba(56, 189, 248, 0.3);">
                                <span id="montant_total_display_text">0</span> <span style="font-size: 16px; font-weight: 700;">FCFA</span>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 24px;">
                            <label for="reference-bordereau">Référence du Bordereau de Livraison (Fournisseur)</label>
                            <input type="text" id="reference-bordereau" class="form-control" placeholder="Ex: BL-CCS-2026-98" required>
                        </div>

                        <button type="submit" class="btn-submit btn-success" style="padding: 16px 24px; font-weight: 800; font-size: 14px;">Enregistrer & Augmenter Stocks (DML)</button>
                    </form>
                </div>

                <!-- Add Supplier Panel -->
                <div class="panel-card" style="margin-top: 32px; margin-bottom: 0;">
                    <div class="panel-title">Enregistrer un Fournisseur</div>
                    <form onsubmit="event.preventDefault(); alert('Fournisseur simulé enregistré avec succès !');">
                        <div class="form-group">
                            <label for="nom-fournisseur">Nom de l'Entreprise</label>
                            <input type="text" id="nom-fournisseur" class="form-control" placeholder="Ex: Comptoir Céréalier Sénégalais" required>
                        </div>
                        <div class="form-group">
                            <label for="tel-fournisseur">Téléphone de Contact</label>
                            <input type="text" id="tel-fournisseur" class="form-control" placeholder="Ex: 338245678" required>
                        </div>
                        <div class="form-group">
                            <label for="adr-fournisseur">Adresse / Ville</label>
                            <input type="text" id="adr-fournisseur" class="form-control" placeholder="Ex: Port de Dakar, Hangar 4" required>
                        </div>
                        <button type="submit" class="btn-submit">Créer le Fournisseur (DML)</button>
                    </form>
                </div>
            </div>

            <!-- Right Side: Complex Slips Table, Filters, Stock triggers -->
            <div>
                <!-- Delivery Slips Registry with filters -->
                <div class="panel-card" style="margin-bottom: 32px;">
                    <div class="panel-title">Bordereaux de Livraison (Réceptions)</div>
                    
                    <!-- Advanced Filters & Search Ribbon -->
                   <form action="" method="GET">

                    <div class="filter-ribbon">
                        <div class="search-bar">
                            <input name="" type="text" id="search-input" class="search-input" onkeyup="filterSlips()" placeholder="Rechercher par Fournisseur ou BL...">
                        </div>
                        <div class="filter-chips">
                            <span class="chip active" onclick="setFilter('tous', this)">Tout</span>
                            <span class="chip" onclick="setFilter('encours', this)">En cours</span>
                            <span class="chip" onclick="setFilter('receptionne', this)">Réceptionnés</span>
                        </div>
                    </div>

                   </form>

                    <!-- Slips Container -->
                    <div id="slips-container">

                        <?php
                         $approvs = $approvs ?? [];
                         foreach($approvs as $approv):
                         ?>

                        <div class="panel-card" style="padding: 20px; border-radius: 16px; margin-bottom: 16px; background: rgba(255,255,255,0.01);">

                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                                <div>
                                    <span style="font-size: 11px; color: var(--text-muted); font-weight: 700;">Réf: <?= $approv['ref_bl'] ?> • <?= $approv['date_app'] ?></span>
                                    <div style="font-size: 16px; font-weight: 700;"><?= $approv['nomf'] ?></div>
                                </div>
                                <span class="badge <?= $approv['clascol'] ?>" id="status-2"><?= $approv['noms'] ?></span>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div style="font-size: 18px; font-weight: 800; color: var(--accent);"><?= $approv['montant'] ?>FCFA</div>
                                <div style="display: flex; gap: 8px;">
                                    <?php if($approv['noms'] =='RECEPTIONNER'):?>
                                        <button class="btn-quick-action" onclick="toggleDetails('details-<?= $approv['id'] ?>')">Voir articles (<?= $approv['nbr_id'] ?>)</button>
                                    <?php else: ?>
                                        <button class="btn-quick-action" style="border-color: var(--success); color: var(--success);" id="btn-receptive-<?= $approv['id'] ?>" onclick="receptionSlip(<?= $approv['id'] ?>)">Réceptionner</button>
                                    <?php endif ?>
                                </div>
                            </div>

                            <?php if($approv['noms'] =='RECEPTIONNER'):?>

                                <div class="details-drawer" id="details-<?= $approv['id'] ?>">
                                    <div style="font-weight: 700; font-size: 12px; color: var(--accent); margin-bottom: 8px;">Lignes d'articles reçus :</div>
                                    <?php foreach($approv['ligne'] as $ligne):?>
                                    <div style="display: flex; justify-content: space-between; font-size: 12px; color: var(--text-muted);">
                                        <span><?= $ligne['qt_appro'] ?> x <?= $ligne['libelle'] ?>  (achat à <?= $ligne['prix_achatreell'] ?> F/u)</span>
                                        <span style="font-weight: 700; color: var(--text-main);"><?= $ligne['sous_total'] ?> F</span>
                                    </div>
                                    <?php endforeach ?>
                                </div>

                            <?php else: ?>

                                <form action="http://localhost:7000/modiAppro" method="POST">
                                    <div class="details-drawer" id="details-<?= $approv['id'] ?>">
                                            <input type="hidden" name="appro_id" value="<?= $approv['id'] ?>">
                                        <div id="details-<?= $approv['id'] ?>-static" style="display: none;">
                                            <div style="font-weight: 700; font-size: 12px; color: var(--accent); margin-bottom: 8px;">Lignes d'articles réceptionnés :</div>
                                            <div id="details-<?= $approv['id'] ?>-static-lines"></div>
                                        </div>

                                        <div id="details-<?= $approv['id'] ?>-editor">
                                            <div style="font-weight: 700; font-size: 12px; color: var(--accent); margin-bottom: 12px;">Saisie des Quantités Reçues et Coûts Réels :</div>
                                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                                <?php foreach($approv['ligne'] as $ligne):?>
                                                <div style="display: grid; grid-template-columns: 2fr 1fr 1.2fr; gap: 12px; align-items: center; padding-bottom: 8px; border-bottom: 1px solid rgba(255,255,255,0.03);">
                                                    <span style="font-weight:700; font-size:12px;"><?= $ligne['libelle'] ?> (Attendu: <?= $ligne['qt_appro'] ?>)</span>
                                                    <div>
                                                        <label style="font-size:9px; color:var(--text-muted); display:block; margin-bottom:2px;">Qté Reçue</label>
                                                        <input name="ligne[<?= $ligne['id1'] ?>][qte_recu]" type="number" id="recept-qty-<?= $approv['id'] ?>-1" class="form-control" value="" style="padding:4px 8px; font-size:11px;">
                                                    </div>
                                                    <div>
                                                        <label style="font-size:9px; color:var(--text-muted); display:block; margin-bottom:2px;">Coût Achat (F)</label>
                                                        <input name="ligne[<?= $ligne['id1'] ?>][prix_reel]" type="number" id="recept-price-<?= $approv['id'] ?>-1" class="form-control" value="<?= $ligne['prix_achatreell'] ?>" style="padding:4px 8px; font-size:11px;">
                                                        <input type="hidden" name="ligne[<?= $ligne['id1'] ?>][article_id]" value="<?= $ligne['id2'] ?>">
                                                    </div>
                                                </div>
                                                <?php endforeach ?>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn-submit btn-success" style="margin-top: 14px; padding: 10px 16px; font-size: 11px; width: auto;" onclick="validateReceptionComplex(<?= $approv['id'] ?>)">Confirmer et réceptionner les quantités saisies</button>

                                    </div>
                                </form>

                            <?php endif ?>

                        </div>

                        <?php endforeach ?>

                    </div>
                </div>

                <!-- Out of stock triggers / Replenishment Mail draft -->
                <div class="panel-card">
                    <div class="panel-title" style="border-left-color: var(--danger);">⚠️ Niveaux de Stocks & Approvisionnement direct</div>
                    <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 16px;">
                        Générez instantanément des bons de commande pour vos fournisseurs pour les produits en alerte :
                    </p>
                    <div style="display: flex; flex-direction: column; gap: 14px;">

                        <!-- Stock item 1 -->

                                <?php
                                 $articles = $articles ?? [];
                                 foreach($articles as $article):
                                 ?>

                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.03); padding-bottom: 8px;">
                            <div>
                                <div style="font-weight: 700; font-size: 13px;"><?= $article['libelle'] ?></div>
                                <span style="font-size: 11px; color: var(--<?= $article['stockcol'] ?>); font-weight: 700;">Alerte : <?= $article['stock']  ?> en stock</span>
                            </div>
                            <button class="btn-quick-action" onclick="toggleOrderDraft('draft-<?= $article['id'] ?>', '<?= $article['libelle'] ?>', '<?= $article['nom'] ?>', 50)">Commander</button>
                        </div>
                        <div class="order-draft-panel" id="draft-<?= $article['id'] ?>">
                            <div style="font-weight: 700; margin-bottom: 6px; color: var(--accent);">Demande d'Approvisionnement Automatique</div>
                            <textarea class="draft-textarea" id="text-draft-<?= $article['id'] ?>"></textarea>
                            <button type="button" class="btn-quick-action" style="font-size: 10px; width: 100%; border-color: var(--success); color: var(--success);" onclick="copyDraft('text-draft-<?= $article['id'] ?>')">Copier le bon de commande</button>
                        </div>

                         <?php endforeach ?>

                    </div>
                </div>

                <!-- Ledger Audit Chart -->
                <div class="panel-card" style="margin-bottom: 0;">
                    <div class="panel-title success-border">Grand Livre de Rapprochement des Entrées</div>
                    <table class="debt-table" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th>Réf BL</th>
                                <th>Fournisseur</th>
                                <th>Valeur Facturée</th>
                                <th>Valeur Réceptionnée</th>
                                <th>Diagnostic</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                                 $appros = $appros ?? [];
                                 foreach($appros as $appro):
                                 ?>
                            <tr>
                                <td style="font-weight: 700;"><?= $appro['ref_bl'] ?></td>
                                <td><?= $appro['nom'] ?></td>
                                <td><?= $appro['montantfacture'] ?> FCFA</td>
                                <td><?= $appro['montantreel'] ?> FCFA</td>
                                <td style="color: var(--<?= $appro['color'] ?>); font-weight: 700;"><?= $appro['diagnos'] ?></td>
                            </tr>
                             <?php endforeach ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- JavaScript Cart, Filters, Alerts & simulators -->
<script>
        const cart = [];
        let currentFilter = 'tous';

        function toggleDetails(panelId) {
            const panel = document.getElementById(panelId);
            const isVisible = window.getComputedStyle(panel).display !== 'none';
            panel.style.display = isVisible ? 'none' : 'block';
        }

        // Live Supply Cart Simulator
        function addToCart(event) {
            event.preventDefault();
            const select = document.getElementById("pos-item-select");
            const price = parseFloat(select.value);
            const name = select.options[select.selectedIndex].getAttribute("data-name");
            const qty = parseInt(document.getElementById("pos-qty").value);

            if (qty <= 0) return;

            const existing = cart.find(item => item.name === name);
            if (existing) {
                existing.qty += qty;
                existing.total = existing.qty * price;
            } else {
                cart.push({ name, price, qty, total: qty * price });
            }

            renderCart();
        }

        function removeCartItem(index) {
            cart.splice(index, 1);
            renderCart();
        }

        function renderCart() {
            const body = document.getElementById("cart-rows");
            const textDisplay = document.getElementById("montant_total_display_text");

            if (cart.length === 0) {
                body.innerHTML = `
                    <tr id="empty-cart-row">
                        <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 16px 0; border-bottom: none;">Aucun article dans ce lot. Ajoutez des lignes.</td>
                    </tr>
                `;
                textDisplay.innerText = "0";
                return;
            }

            body.innerHTML = "";
            let overallTotal = 0;

            cart.forEach((item, index) => {
                overallTotal += item.total;
                body.innerHTML += `
                    <tr>
                        <td style="padding: 8px 0; font-weight:700;">${item.name}</td>
                        <td style="padding: 8px 0;">${item.qty}</td>
                        <td style="padding: 8px 0; font-weight:800; color:var(--accent);">${new Intl.NumberFormat('fr-FR').format(item.total)} F</td>
                        <td style="padding: 8px 0; text-align:right;">
                            <button type="button" onclick="removeCartItem(${index})" style="background:none; border:none; color:var(--danger); cursor:pointer; font-size:14px;">🗑️</button>
                        </td>
                    </tr>
                `;
            });

            textDisplay.innerText = new Intl.NumberFormat('fr-FR').format(overallTotal);
        }

        // Simulators actions
        function receptionSlip(id) {
            // Open the details drawer directly to let the user review/edit quantities
            toggleDetails('details-' + id);
        }

        function validateReceptionComplex(id) {
            // Read inputs
            const qty1 = parseInt(document.getElementById("recept-qty-2-1").value);
            const price1 = parseFloat(document.getElementById("recept-price-2-1").value);

            const qty2 = parseInt(document.getElementById("recept-qty-2-2").value);
            const price2 = parseFloat(document.getElementById("recept-price-2-2").value);

            const qty3 = parseInt(document.getElementById("recept-qty-2-3").value);
            const price3 = parseFloat(document.getElementById("recept-price-2-3").value);

            const actualTotal = (qty1 * price1) + (qty2 * price2) + (qty3 * price3);

            // Build static list

            // Show static view and hide editor view
            document.getElementById("details-2-editor").style.display = "none";
            document.getElementById("details-2-static").style.display = "block";

            // Update Card Title amount & status
            const card = document.querySelector('[data-ref="BL-DIP-012"]');
            card.setAttribute("data-status", "receptionne");

            // Update UI status badge & hide validate buttons

            const btnReceptive = document.getElementById("btn-receptive-" + id);
            if (btnReceptive) btnReceptive.style.display = "none";

            // Update card total display text


            // Update Ledger Audit Table

        }

        // Toggle Order Draft Generator
        function toggleOrderDraft(panelId, item, supplier, defaultQty) {
            const panel = document.getElementById(panelId);
            const isVisible = window.getComputedStyle(panel).display !== 'none';

            if (isVisible) {
                panel.style.display = 'none';
            } else {
                panel.style.display = 'block';
                const txt = document.getElementById("text-" + panelId);
                txt.value = `BON DE COMMANDE FOURNISSEUR\n\nÀ l'attention de : ${supplier}\nObjet : Commande de réapprovisionnement pour ${item}\n\nBonjour,\nNous constatons une rupture ou un stock critique sur le produit ${item}. Par la présente, nous sollicitons la livraison d'un lot de ${defaultQty} unités à notre dépôt principal.\nMerci de nous faire parvenir votre facture proforma correspondante.\n\nCordialement,\nService Logistique SupplyPro.`;
            }
        }

        function copyDraft(txtId) {
            const text = document.getElementById(txtId);
            text.select();
            document.execCommand("copy");
            alert("Message du bon de commande copié dans le presse-papier !");
        }

        // Advanced local filter
        function filterSlips() {
            const query = document.getElementById("search-input").value.toLowerCase();
            const cards = document.querySelectorAll("#slips-container > .panel-card");

            cards.forEach(card => {
                const supplier = card.getAttribute("data-supplier").toLowerCase();
                const ref = card.getAttribute("data-ref").toLowerCase();
                const status = card.getAttribute("data-status");

                const matchesQuery = supplier.includes(query) || ref.includes(query);
                const matchesFilter = (currentFilter === 'tous') || (status === currentFilter);

                if (matchesQuery && matchesFilter) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        }

        function setFilter(filterType, chip) {
            document.querySelectorAll(".chip").forEach(c => c.classList.remove("active"));
            chip.classList.add("active");
            currentFilter = filterType;
            filterSlips();
        }
</script>
</body>
</html>