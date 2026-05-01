<?php
$today    = count(array_filter($events, fn($e) => $e['event_date'] === date('Y-m-d')));
$thisWeek = count(array_filter($events, fn($e) => date('W', strtotime($e['event_date'])) === date('W')));
$confirmed= count(array_filter($events, fn($e) => in_array($e['status'], ['confirmado','en_ejecucion'])));
?>

<!-- ══ MODULE HEADER ═════════════════════════════════════ -->
<div class="module-header">
    <div class="module-header-bg"></div>
    <div class="flex items-center justify-between gap-6">
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest mb-2" style="color: #6366f1;">Operación</p>
            <h1 class="text-2xl font-extrabold text-slate-900">Eventos</h1>
            <p class="text-slate-500 text-sm mt-1">Agenda, logística y seguimiento operativo</p>
        </div>
        <button data-open-modal="eventModal" class="btn-primary shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo evento
        </button>
    </div>

    <!-- Stats strip -->
    <div class="flex gap-6 mt-6 pt-5" style="border-top: 1px solid #f1f5f9;">
        <div><p class="text-xl font-extrabold text-slate-900"><?= count($events) ?></p><p class="text-xs text-slate-400 mt-0.5">Total eventos</p></div>
        <?php if ($today > 0): ?>
        <div style="border-left:1px solid #f1f5f9;padding-left:24px;"><p class="text-xl font-extrabold text-amber-600"><?= $today ?></p><p class="text-xs text-slate-400 mt-0.5">Hoy</p></div>
        <?php endif; ?>
        <div style="border-left:1px solid #f1f5f9;padding-left:24px;"><p class="text-xl font-extrabold text-indigo-600"><?= $thisWeek ?></p><p class="text-xs text-slate-400 mt-0.5">Esta semana</p></div>
        <div style="border-left:1px solid #f1f5f9;padding-left:24px;"><p class="text-xl font-extrabold text-emerald-600"><?= $confirmed ?></p><p class="text-xs text-slate-400 mt-0.5">Confirmados</p></div>
    </div>
</div>

<!-- ══ EVENTS LIST ════════════════════════════════════════ -->
<?php if (empty($events)): ?>
    <div class="card">
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h3>Sin eventos programados</h3>
            <p>Agrega tu primer evento para comenzar a gestionar la agenda.</p>
            <button data-open-modal="eventModal" class="btn-primary">+ Programar evento</button>
        </div>
    </div>
<?php else: ?>
<div class="space-y-3">
    <?php foreach ($events as $ev):
        $start  = date('Ymd\THis', strtotime($ev['event_date'] . ' ' . ($ev['start_time'] ?: '08:00')));
        $end    = date('Ymd\THis', strtotime($ev['event_date'] . ' ' . ($ev['end_time']   ?: '17:00')));
        $calUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
            . '&text='     . rawurlencode($ev['name'])
            . '&dates='    . $start . '/' . $end
            . '&details='  . rawurlencode('Cliente: ' . $ev['client_name'] . "\nCotización: " . ($ev['quote_code'] ?? 'Sin relacionar') . "\nEquipo: " . $ev['team_notes'])
            . '&location=' . rawurlencode($ev['venue'] . ', ' . $ev['city']);
        $isToday = $ev['event_date'] === date('Y-m-d');
    ?>
        <div class="card ev-border-<?= e($ev['status']) ?>"
             style="padding: 18px 22px; display:flex; align-items:center; gap:18px; transition: box-shadow 0.15s, transform 0.15s; <?= $isToday ? 'background: #fafbff;' : '' ?>">

            <!-- Date -->
            <div class="date-box shrink-0" style="<?= $isToday ? 'background: linear-gradient(145deg, #059669, #10b981); box-shadow: 0 4px 12px rgba(16,185,129,0.4);' : '' ?>">
                <span class="date-box-day"><?= e(date('d', strtotime($ev['event_date']))) ?></span>
                <span class="date-box-month"><?= e(date('M', strtotime($ev['event_date']))) ?></span>
            </div>

            <!-- Main info -->
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2.5 flex-wrap mb-1.5">
                    <h3 class="font-bold text-slate-900"><?= e($ev['name']) ?></h3>
                    <?= statusBadge($ev['status']) ?>
                    <?php if ($isToday): ?>
                        <span class="badge badge-emerald" style="font-size:0.7rem;">HOY</span>
                    <?php endif; ?>
                </div>

                <div class="flex items-center gap-4 flex-wrap" style="font-size:0.8125rem; color:#64748b;">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <?= e($ev['client_name']) ?>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <?= e($ev['venue']) ?>, <?= e($ev['city']) ?>
                    </span>
                    <?php if ($ev['start_time']): ?>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <?= e(substr($ev['start_time'], 0, 5)) ?> &ndash; <?= e(substr($ev['end_time'] ?: '17:00', 0, 5)) ?>
                    </span>
                    <?php endif; ?>
                </div>

                <?php if ($ev['quote_code'] || $ev['expected_margin']): ?>
                <div class="flex gap-2 mt-2.5">
                    <?php if ($ev['quote_code']): ?>
                        <span class="badge badge-gray"><?= e($ev['quote_code']) ?></span>
                    <?php endif; ?>
                    <?php if ($ev['expected_margin']): ?>
                        <span class="badge badge-emerald">Margen <?= e($ev['expected_margin']) ?>%</span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2 shrink-0">
                <a class="btn-ghost text-xs" href="/eventos/editar?id=<?= e($ev['id']) ?>">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editar
                </a>
                <a class="btn-secondary text-xs" href="<?= e($calUrl) ?>" target="_blank" rel="noopener">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Google Cal
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- ══ MODAL ════════════════════════════════════════════ -->
<dialog id="eventModal" class="modal">
    <div class="modal-inner">
        <div class="modal-header">
            <div class="flex items-start gap-3">
                <div class="modal-header-icon">
                    <svg class="w-5 h-5" fill="none" stroke="#6366f1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h2 class="modal-title"><?= e($formTitle) ?></h2>
                    <p class="modal-subtitle">Programación, logística y notas de equipo</p>
                </div>
            </div>
            <button type="button" class="modal-close" onclick="closeModal('eventModal')">✕</button>
        </div>

        <form method="post" action="<?= e($formAction) ?>">
            <?php if ($event !== null): ?>
                <input type="hidden" name="id" value="<?= e($event['id']) ?>">
            <?php endif; ?>

            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-section">
                        <p class="form-section-title">Información general</p>
                    </div>

                    <label>
                        <span class="form-label">Cliente <span class="text-red-400">*</span></span>
                        <select class="form-select" name="client_id" required>
                            <?php foreach ($clients as $cl): ?>
                                <option value="<?= e($cl['id']) ?>" <?= (int)($event['client_id'] ?? 0) === (int)$cl['id'] ? 'selected' : '' ?>><?= e($cl['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span class="form-label">Cotización relacionada</span>
                        <select class="form-select" name="quote_id">
                            <option value="">Sin relacionar</option>
                            <?php foreach ($quotes as $qt): ?>
                                <option value="<?= e($qt['id']) ?>" <?= (int)($event['quote_id'] ?? 0) === (int)$qt['id'] ? 'selected' : '' ?>><?= e($qt['code']) ?> — <?= e($qt['event_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label class="span-2">
                        <span class="form-label">Nombre del evento <span class="text-red-400">*</span></span>
                        <input class="form-input" name="name" value="<?= e($event['name'] ?? '') ?>" required placeholder="Ej. Día de integración Bancolombia">
                    </label>

                    <div class="form-section">
                        <p class="form-section-title">Fecha y horario</p>
                    </div>

                    <label>
                        <span class="form-label">Fecha <span class="text-red-400">*</span></span>
                        <input class="form-input" name="event_date" type="date" value="<?= e($event['event_date'] ?? '') ?>" required>
                    </label>

                    <label>
                        <span class="form-label">Estado</span>
                        <select class="form-select" name="status">
                            <?php foreach (['programado' => 'Programado', 'confirmado' => 'Confirmado', 'en_ejecucion' => 'En ejecución', 'finalizado' => 'Finalizado', 'cancelado' => 'Cancelado'] as $val => $lbl): ?>
                                <option value="<?= e($val) ?>" <?= ($event['status'] ?? 'programado') === $val ? 'selected' : '' ?>><?= e($lbl) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span class="form-label">Hora inicio</span>
                        <input class="form-input" name="start_time" type="time" value="<?= e(isset($event['start_time']) ? substr((string)$event['start_time'], 0, 5) : '') ?>">
                    </label>

                    <label>
                        <span class="form-label">Hora fin</span>
                        <input class="form-input" name="end_time" type="time" value="<?= e(isset($event['end_time']) ? substr((string)$event['end_time'], 0, 5) : '') ?>">
                    </label>

                    <div class="form-section">
                        <p class="form-section-title">Ubicación y márgenes</p>
                    </div>

                    <label>
                        <span class="form-label">Lugar / Venue</span>
                        <input class="form-input" name="venue" value="<?= e($event['venue'] ?? '') ?>" placeholder="Centro de convenciones XYZ">
                    </label>

                    <label>
                        <span class="form-label">Ciudad</span>
                        <input class="form-input" name="city" value="<?= e($event['city'] ?? '') ?>" placeholder="Bogotá">
                    </label>

                    <label class="span-2">
                        <span class="form-label">Margen esperado %</span>
                        <input class="form-input" name="expected_margin" type="number" min="0" max="100" step="0.1" value="<?= e($event['expected_margin'] ?? '') ?>" placeholder="40">
                    </label>

                    <div class="form-section">
                        <p class="form-section-title">Notas operativas</p>
                    </div>

                    <label class="span-2">
                        <span class="form-label">Notas de equipo</span>
                        <textarea class="form-textarea" name="team_notes" placeholder="Instrucciones para el equipo, responsables, roles…"><?= e($event['team_notes'] ?? '') ?></textarea>
                    </label>

                    <label class="span-2">
                        <span class="form-label">Logística</span>
                        <textarea class="form-textarea" name="logistics_notes" placeholder="Transporte, montaje, lista de materiales…"><?= e($event['logistics_notes'] ?? '') ?></textarea>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <?php if ($event !== null): ?>
                    <a class="btn-secondary" href="/eventos">Cancelar</a>
                <?php endif; ?>
                <button type="submit" class="btn-primary"><?= e($submitLabel) ?></button>
            </div>
        </form>
    </div>
</dialog>

<?php if ($event !== null): ?>
<script>document.addEventListener('DOMContentLoaded', () => openModal('eventModal'));</script>
<?php endif; ?>
