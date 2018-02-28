var wgtVer = null;

function checkUpdate() {
	var i = arguments;
	if (!wgtVer) {
		plus.runtime.getProperty(plus.runtime.appid, function(a) {
			wgtVer = a.version;
			console.log("当前应用版本：" + wgtVer);
			checkUpdate(typeof i[0] != "undefined" ? i[0] : 0)
		});
		return false
	}
	var g = window.localStorage.getItem("updated"),
		h = mui.now(),
		j = 10 * 60 * 1000;
	var f = (typeof arguments[0] != "undefined" && arguments[0] == 1);
	if (!g || h - g > j || f) {
		window.localStorage.setItem("updated", h.toString());
		mui.sendRequest(mui.constMap.ROOT_PATH + "update", {
			version: wgtVer,
			ios: mui.os.ios ? 1 : 0,
			config: {
				silence: !f,
				error_show: false
			}
		}, function(b) {
			if (!b.status.succeed) {
				var a = b.status.error_desc.split(",")[0];
				if (a == "abort" || a == "timeout") {
					mui.confirm("网络出错，请检查网络配置", "温馨提示", ["退出", "设置"], function(c) {
						if (c.index == 0) {
							if (mui.os.ios) {
								mui.alert("请双击Home键退出程序")
							} else {
								plus.runtime.quit()
							}
						} else {
							if (mui.os.ios) {
								plus.runtime.launchApplication({
									action: "prefs:root=MOBILE_DATA_SETTINGS_ID"
								}, function(k) {})
							} else {
								var l = plus.android.runtimeMainActivity();
								var d = plus.android.importClass("android.content.Intent");
								var e = new d("android.settings.WIFI_SETTINGS");
								l.startActivity(e)
							}
						}
					})
				} else {
					mui.toast(b.status.error_desc)
				}
				return
			}
			if (b.data.update.length > 0) {
				if (typeof b.data.download != "undefined" && b.data.download == 1) {
					mui.alert("本次更新内容较多，请在浏览器中重新下载并安装", "温馨提示", "确定", function(c) {
						plus.runtime.openURL(b.data.update)
					})
				} else {
					downWgt(b.data.update)
				}
			} else {
				if (f) {
					mui.alert("当前已是最新版本")
				}
			}
		})
	}
}

function downWgt(b) {
	mui.confirm("已检测到新版本，是否立即更新？", "温馨提示", ["是", "否"], function(d) {
		if (d.index == 0) {
			plus.nativeUI.showWaiting("下载更新中...");
			plus.downloader.createDownload(b, {
				filename: "_doc/update/"
			}, function(c, g) {
				if (g == 200) {
					console.log("下载成功：" + c.filename);
					installWgt(c.filename)
				} else {
					console.log("下载失败！");
					plus.nativeUI.alert("更新失败！")
				}
				plus.nativeUI.closeWaiting()
			}).start()
		}
	})
}

function installWgt(b) {
	plus.nativeUI.showWaiting("更新文件...");
	plus.runtime.install(b, {}, function() {
		plus.nativeUI.closeWaiting();
		console.log("更新文件成功！");
		plus.nativeUI.alert("应用资源更新完成！", function() {
			plus.runtime.restart()
		})
	}, function(a) {
		plus.nativeUI.closeWaiting();
		console.log("更新文件失败[" + a.code + "]：" + a.message);
		if (a.code != -1205) {
			plus.nativeUI.alert("更新失败[" + a.code + "]：" + a.message)
		}
	})
};