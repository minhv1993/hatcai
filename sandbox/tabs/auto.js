var tabsHelper = {
    bid: 0,
    serviceURL: $("input[name=tabsHelperServices]").val() + '?block=tabs&',
    init: function () {
        this.tabSetup();

        $('#addTab').click(function () {
            tabsHelper.addTab();
            return false;
        });
        $('#editTab').click(function () {
            tabsHelper.addTab('Edit');
            return false;
        });
        $('#cancelEditTab').click(function () {
            $('#editTabsTable').show();
            $('#editTabForm').css('display', 'none');
        });
        this.serviceURL += 'cID=' + this.cID + '&arHandle=' + this.arHandle + '&bID=' + this.bID + '&btID=' + this.btID + '&';
        tabsHelper.refreshTabsView();
    },
    tabSetup: function () {
        $('ul#ccm-formblock-tabs li a').each(function (num, el) {
            el.onclick = function () {
                var pane = this.id.replace('ccm-formblock-tab-', '');
                tabsHelper.showPane(pane);
            }
        });
    },
    showPane: function (pane) {
        $('ul#ccm-formblock-tabs li').each(function (num, el) {
            $(el).removeClass('active')
        });
        $(document.getElementById('ccm-formblock-tab-' + pane).parentNode).addClass('active');
        $('div.ccm-formBlockPane').each(function (num, el) {
            el.style.display = 'none';
        });
        $('#ccm-formBlockPane-' + pane).css('display', 'block');
    },
    refreshTabsView: function () {
        $.ajax({
            url: this.serviceURL + 'mode=refreshTabsView&tsID=' + parseInt(this.tsID) + '&hide=' + tabsHelper.hideTabs.join(','),
            success: function (msg) {
                $('#tabsPreviewWrap').html(msg);
            }
        });
        $.ajax({
            url: this.serviceURL + 'mode=refreshTabsView&tsID=' + parseInt(this.tsID) + '&showEdit=1&hide=' + tabsHelper.hideTabs.join(','),
            success: function (msg) {
                $('#editTabsTableWrap').html(msg);
            }
        });
    },
    addTab: function (mode) {
        var msqID = 0;
        if (mode != 'Edit') {
            mode = '';
        } else {
            msqID = parseInt($('#msqID').val(), 10);
        }
        var postStr = 'tabName=' + encodeURIComponent($('#tabName' + mode).val());
        postStr += '&tabIdStr=' + encodeURIComponent($('#tabIdStr' + mode).val());
        postStr += '&position=' + escape($('#position' + mode).val());
        var form = document.getElementById('ccm-block-form');
        postStr += '&msqID=' + msqID + '&tsID=' + parseInt(this.tsID);
        $.ajax({
            type: "POST",
            data: postStr,
            url: this.serviceURL + 'mode=addTab&tsID=' + parseInt(this.tsID),
            success: function (msg) {
                eval('var jsonObj=' + msg);
                if (!jsonObj) {
                    alert(ccm_t('ajax-error'));
                } else if (jsonObj.noRequired) {
                    alert(ccm_t('complete-required'));
                } else {
                    if (jsonObj.mode == 'Edit') {
                        var tabMsg = $('#tabEditedMsg');
                        tabMsg.fadeIn();
                        setTimeout(function () {
                            tabMsg.fadeOut();
                        }, 5000);
                        if (jsonObj.hideTID) {
                            tabsHelper.hideTabs.push(tabsHelper.edit_tID); //jsonObj.hideTID);
                            tabsHelper.edit_tID = 0;
                        }
                    } else {
                        var tabMsg = $('#tabAddedMsg');
                        tabMsg.fadeIn();
                        setTimeout(function () {
                            tabMsg.fadeOut();
                        }, 5000);
                    }
                    $('#editTabForm').css('display', 'none');
                    $('#editTabsTable').show();
                    tabsHelper.tsID = jsonObj.tsID;
                    tabsHelper.ignoreTabId(jsonObj.msqID);
                    $('#tsID').val(jsonObj.tsID);
                    tabsHelper.resetTab();
                    tabsHelper.refreshTabsView();
                }
            }
        });
    },
    //prevent duplication of these tabs, for block tab versioning
    ignoreTabId: function (msqID) {
        var msqID, ignoreEl = $('#ccm-ignoreTabIDs');
        if (ignoreEl.val()) msqIDs = ignoreEl.val().split(',');
        else msqIDs = [];
        msqIDs.push(parseInt(msqID, 10));
        ignoreEl.val(msqIDs.join(','));
    },
    reloadTab: function (tID) {

        $.ajax({
            url: this.serviceURL + "mode=getTab&tsID=" + parseInt(this.tsID) + '&tID=' + parseInt(tID),
            success: function (msg) {
                eval('var jsonObj=' + msg);
                $('#editTabForm').css('display', 'block'); tabIdStr
                $('#tabNameEdit').val(jsonObj.tabName);
                $('#tabIdStrEdit').val(jsonObj.tabIdStr);
                $('#positionEdit').val(jsonObj.position);
                
                $('#msqID').val(jsonObj.msqID);
                $('#editTabsTable').hide();

                if (parseInt(jsonObj.bID) > 0)
                    tabsHelper.edit_tID = parseInt(tID);
                $('.tabsHelperOptions').first().closest('.ui-dialog-content').get(0).scrollTop = 0;
            }
        });
    },
    //prevent duplication of these tabs, for block tab versioning
    pendingDeleteTabId: function (msqID) {
        var msqID, el = $('#ccm-pendingDeleteIDs');
        if (el.val()) msqIDs = el.val().split(',');
        else msqIDs = [];
        msqIDs.push(parseInt(msqID, 10));
        el.val(msqIDs.join(','));
    },
    hideTabs: [],
    deleteTab: function (el, msqID, tID) {
        if (confirm(ccm_t('delete-tab'))) {
            $.ajax({
                url: this.serviceURL + "mode=delTab&tsID=" + parseInt(this.tsID) + '&msqID=' + parseInt(msqID),
                success: function (msg) {
                    tabsHelper.resetTab();
                    tabsHelper.refreshTabsView();
                }
            });

            tabsHelper.ignoreTabId(msqID);
            tabsHelper.hideTabs.push(tID);
            tabsHelper.pendingDeleteTabId(msqID)
        }
    },
    resetTab: function () {
        $('#tabName').val('');
        $('#tabIdStr').val('');
        $('#msqID').val('');
    },

    validate: function () {
        var failed = 0;

        var Qs = $('.tabsHelperTabNameRow');
        if (!Qs || parseInt(Qs.length, 10) < 1) {
            alert(ccm_t('form-min-1'));
            failed = 1;
        }

        if (failed) {
            ccm_isBlockError = 1;
            return false;
        }
        return true;
    },

    moveUp: function (el, thisTID) {
        var tIDs = this.serialize();
        var previousQID = 0;
        for (var i = 0; i < tIDs.length; i++) {
            if (tIDs[i] == thisTID) {
                if (previousQID == 0) break;
                $('#tabsHelperTabNameRow' + thisTID).after($('#tabsHelperTabNameRow' + previousQID));
                break;
            }
            previousQID = tIDs[i];
        }
        this.saveOrder();
    },
    moveDown: function (el, thisTID) {
        var tIDs = this.serialize();
        var thisTIDfound = 0;
        for (var i = 0; i < tIDs.length; i++) {
            if (tIDs[i] == thisTID) {
                thisTIDfound = 1;
                continue;
            }
            if (thisTIDfound) {
                $('#tabsHelperTabNameRow' + tIDs[i]).after($('#tabsHelperTabNameRow' + thisTID));
                break;
            }
        }
        this.saveOrder();
    },
    serialize: function () {
        var t = document.getElementById("tabsHelperPreviewTable");
        var tIDs = [];
        for (var i = 0; i < t.childNodes.length; i++) {
            if (t.childNodes[i].className && t.childNodes[i].className.indexOf('tabsHelperTabNameRow') >= 0) {
                var tID = t.childNodes[i].id.substr('tabsHelperTabNameRow'.length);
                tIDs.push(tID);
            }
        }
        return tIDs;
    },
    saveOrder: function () {
        var postStr = 'tIDs=' + this.serialize().join(',') + '&tsID=' + parseInt(this.tsID);
        $.ajax({
            type: "POST",
            data: postStr,
            url: this.serviceURL + "mode=reorderTab",
            success: function (msg) {
                tabsHelper.refreshTabsView();
            }
        });
    }
};
ccmValidateBlockForm = function () {
    return tabsHelper.validate();
};
$(document).ready(function () {
    //tabsHelper.init();
    /* TODO hackzors, this shouldnt be necessary */
    $('#ccm-block-form').closest('div').addClass('ccm-ui');
});
